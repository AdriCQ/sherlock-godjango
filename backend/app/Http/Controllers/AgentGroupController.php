<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentGroupController extends Controller
{
    /**
     * addAgent
     * @param int $id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function addAgent(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_id' => ['required', 'integer']
        ]);
        $group = AgentGroup::find($id);
        if ($validator->fails() || !$group) {
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        $agent = Agent::query()->find($validator['agent_id']);
        if (!$agent)
            return $this->sendResponse(null, 'Verifique los datos enviados', 400);
        $agent->agent_group_id = $id;
        if ($agent->save()) {
            $group->agents;
            return $this->sendResponse($group);
        }
        return $this->sendResponse($agent->errors, 'No se pudo guardar', 503);
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
            'description' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $model = new AgentGroup($validator);
        return $model->save() ? $this->sendResponse($model, null) : $this->sendResponse($model->errors, 'No se pudo guardar el Grupo', 400);
    }

    /**
     * List
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->sendResponse(AgentGroup::query()->with('agents')->get());
    }
    /**
     * Remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        return AgentGroup::find($id) && AgentGroup::find($id)->delete() ? $this->sendResponse(null, 'Eliminado correctamente') : $this->sendResponse(null, null, 503);
    }

    /**
     * removeAgent
     * @param int $id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function removeAgent(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_id' => ['required', 'integer']
        ]);
        $group = AgentGroup::find($id);
        if ($validator->fails() || !$group) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $agent = Agent::query()->find($validator['agent_id']);
        if (!$agent)
            return $this->sendResponse(null, 'Verifique los s enviados', 400);
        $agent->agent_group_id = 1;
        $agent->save();
        $group->agents;
        return $this->sendResponse($group);
    }

    /**
     * Update
     * @param int $id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);
        $model = AgentGroup::find($id);
        if ($validator->fails() || !$model) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        if ($model->update($validator)) {
            $model->agents;
            return $this->sendResponse($model, null);
        }
        return $this->sendResponse($model->errors, 'No se pudo guardar el Grupo', 503);
    }
}
