<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Assignment;
use App\Models\AssignmentCheckpoint;
use App\Models\AssignmentJoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
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
            'state' => ['required', 'string'],
            'agent_id' => ['nullable', 'integer'],

            'checkpoints' => ['required', 'array'],
            'checkpoints.*.name' => ['required', 'string'],
            'checkpoints.*.coordinate' => ['required', 'array'],
            'checkpoints.*.coordinate.lat' => ['required', 'numeric'],
            'checkpoints.*.coordinate.lng' => ['required', 'numeric'],
            'checkpoints.*.status' => ['required', 'in:' . implode(',', AssignmentCheckpoint::$STATUS)],
            'checkpoints.*.initiated_ts' => ['required', 'string'],
            'checkpoints.*.contact' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        // if (!Agent::query()->first()) return $this->sendResponse(null, 'Necesita un agente', 400);
        // $validator['agent_id'] = Agent::query()->first()->id;
        $checkpoints = $validator['checkpoints'];
        unset($validator['checkpoints']);
        $ass = new Assignment($validator);
        $ass->save();
        $ass->checkpoints()->createMany($checkpoints);
        return $this->sendResponse(Assignment::query()->where('id', $ass->id)->with('checkpoints')->first(), 'Asignacion Creada', 201);
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
            'state' => ['nullable', 'string'],
            'agent_id' => ['nullable', 'integer'],

            'checkpoints' => ['nullable', 'array'],
            'checkpoints.*.name' => ['sometimes', 'string'],
            'checkpoints.*.coordinate' => ['sometimes', 'array'],
            'checkpoints.*.coordinate.lat' => ['sometimes', 'numeric'],
            'checkpoints.*.coordinate.lng' => ['sometimes', 'numeric'],
            'checkpoints.*.status' => ['sometimes', 'in:' . implode(',', AssignmentCheckpoint::$STATUS)],
            'checkpoints.*.initiated_ts' => ['sometimes', 'string'],
            'checkpoints.*.contact' => ['sometimes', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        if (!Assignment::find($id)) return $this->sendResponse(null, 'No encontrado', 400);
        Assignment::query()->where('id', $id)->update($validator);
        return $this->sendResponse(Assignment::query()->where('id', $id)->with('checkpoints')->first());
    }
}
