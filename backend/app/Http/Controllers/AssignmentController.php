<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentCheckpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    /**
     * assignCheckpoint
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function assignCheckpoint(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'position' => ['required', 'array'],
            'position.lat' => ['required', 'numeric'],
            'position.lng' => ['required', 'numeric'],
            'initiated_ts' => ['required', 'string'],
            'contact' => ['nullable', 'string'],
        ]);
        $ass = Assignment::find($id);
        if ($validator->fails() || !$ass ||  $ass->status > 0) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $validator['assignment_id'] = $id;
        $model = new AssignmentCheckpoint($validator);
        return $model->save() ?
            $this->sendResponse(Assignment::find($id))
            : $this->sendResponse($model->errors, 'No se pudo crear', 500);
    }
    /**
     * Create
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'observations' => ['required', 'string'],
            'event' => ['required', 'string'],
            'agent_id' => ['nullable', 'integer'],

            'checkpoints' => ['required', 'array'],
            'checkpoints.*.name' => ['required', 'string'],
            'checkpoints.*.position' => ['required', 'array'],
            'checkpoints.*.position.lat' => ['required', 'numeric'],
            'checkpoints.*.position.lng' => ['required', 'numeric'],
            'checkpoints.*.contact' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $checkpoints = $validator['checkpoints'];
        unset($validator['checkpoints']);
        // Agent
        if (!isset($validator['agent_id']))
            $validator['agent_id'] = 2;
        $ass = new Assignment($validator);
        $ass->save();
        $ass->checkpoints()->createMany($checkpoints);
        return $this->sendResponse(Assignment::query()->where('id', $ass->id)->with('checkpoints')->first(), 'Asignacion Creada', 201);
    }

    /**
     * filter
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
            'event' => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
            'agent_id' => ['nullable', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        return $this->sendResponse(Assignment::query()->where($validator)->get());
    }

    /**
     * Find
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function find(int $id)
    {
        return $this->sendResponse(Assignment::find($id));
    }

    /**
     * List
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->sendResponse(Assignment::all());
    }

    /**
     * Remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        return $this->sendResponse(Assignment::query()->where('id', $id)->delete());
    }

    /**
     * removeCheckpoint
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function removeCheckpoint(int $id)
    {
        return $this->sendResponse(AssignmentCheckpoint::query()->where('id', $id)->delete());
    }

    /**
     * update
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
            'event' => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
            'agent_id' => ['nullable', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $model = Assignment::find($id);
        if (!$model || $model->status > 0) return $this->sendResponse(null, 'No encontrado', 400);
        $model->update($validator);
        return $this->sendResponse(Assignment::query()->where('id', $id)->with('checkpoints')->first());
    }

    /**
     * updateCheckpoint
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function updateCheckpoint(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'position' => ['nullable', 'array'],
            'position.lat' => ['sometimes', 'numeric'],
            'position.lng' => ['sometimes', 'numeric'],
            'contact' => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
        ]);
        $checkpoint = AssignmentCheckpoint::find($id);
        if ($validator->fails() || !$checkpoint) {
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        return $checkpoint->update($validator)
            ? $this->sendResponse(Assignment::find($checkpoint->assignment_id))
            : $this->sendResponse($checkpoint->errors, 'No se pudo guardar', 500);
    }
}
