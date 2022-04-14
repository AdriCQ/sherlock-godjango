<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Assignment;
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
            'joins' => ['required', 'array'],
            'joins.*.checkpoint' => ['required', 'string'],
            'joins.*.status' => ['required', 'in:' . implode(',', AssignmentJoin::$STATUS)],
            'joins.*.initiated_ts' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        // if (!Agent::query()->first()) return $this->sendResponse(null, 'Necesita un agente', 400);
        // $validator['agent_id'] = Agent::query()->first()->id;
        $joins = $validator['joins'];
        unset($validator['joins']);
        $ass = new Assignment($validator);
        $ass->save();
        $ass->joins()->createMany($joins);
        return $this->sendResponse(Assignment::query()->where('id', $ass->id)->with('joins')->first(), 'Asignacion Creada', 201);
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
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        Assignment::query()->where('id', $id)->update($validator);
        return $this->sendResponse(Assignment::find($id));
    }
}
