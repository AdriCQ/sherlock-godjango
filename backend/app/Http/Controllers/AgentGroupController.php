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
        if (!$agent || !$agent->belongsToClient(auth()->user()->client->id))
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
        // Check Client
        $validator['client_id'] = auth()->user()->client->id;
        $model = new AgentGroup($validator);
        return $model->save()
            ? $this->sendResponse($model, null)
            : $this->sendResponse($model->errors, 'No se pudo guardar el Grupo', 400);
    }

    /**
     * List
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        if(!auth()->user()->client)
            return $this->sendResponse(null, 'Cliente no encontrado', 401);
        return $this->sendResponse(AgentGroup::query()
            ->where('client_id', auth()->user()->client->id)
            ->with('agents')->get());
    }
    /**
     * Remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        $group = AgentGroup::query()->where([
            ['client_id', auth()->user()->client->id],
            ['id', $id]
        ])->first();
        // Check if exists or if is default
        if (!$group || $group->id === $this->_defaultGroup())
            return $this->sendResponse(null, 'No se puede eliminar el grupo', 400);
        // Move agents
        $agentIds = [];
        foreach ($group->agents as $agent) {
            array_push($agentIds, $agent->id);
        }
        // Update agents
        Agent::query()->whereIn('id', $agentIds)->update(['agent_group_id' => $this->_defaultGroup()]);
        return $group->delete()
            ? $this->sendResponse(null, 'Eliminado correctamente')
            : $this->sendResponse($group->errors, 'No se puede eliminar el grupo', 500);
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
        if ($validator->fails() || !$group || $group->client_id !== auth()->user()->client->id) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $agent = Agent::query()->find($validator['agent_id']);
        if (!$agent)
            return $this->sendResponse(null, 'Verifique los s enviados', 400);
        $agent->agent_group_id = $this->_defaultGroup();
        if ($agent->save()) {
            $group->agents;
            return $this->sendResponse($group);
        }
        return $this->sendResponse($agent->errors, 'No se pudo guardar el agente', 502);
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
        if ($validator->fails() || !$model || $model->client_id !== auth()->user()->client->id) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        if ($model->update($validator)) {
            $model->agents;
            return $this->sendResponse($model, null);
        }
        return $this->sendResponse($model->errors, 'No se pudo guardar el Grupo', 503);
    }

    /**
     * Default Group
     */
    private function _defaultGroup(){
        $group = AgentGroup::query()->where('client_id', auth()->user()->client->id)->first();
        if($group)
            return $group->id;
        return 1;
    }
}
