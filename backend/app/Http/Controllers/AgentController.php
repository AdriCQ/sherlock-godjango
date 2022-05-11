<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{
    /**
     * Create
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => ['nullable', 'string'],
            'others' => ['nullable', 'string'],
            'nick' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
            'agent_group_id' => ['required', 'integer'],
            'position' => ['required', 'array'],
            'position.lat' => ['required', 'numeric'],
            'position.lng' => ['required', 'numeric'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $user = User::find($validator['user_id']);
        if (!$user || !AgentGroup::find($validator['agent_group_id']))
            return $this->sendResponse(null, 'Verifique los datos enviados', 400);
        if ($user->agent)
            return $this->sendResponse($user->agent);
        $model = new Agent($validator);
        $catArray = $validator['categories'];
        unset($validator['categories']);
        if ($model->save()) {
            $model->categories()->attach($catArray);
            return $this->sendResponse($model);
        }
        return $this->sendResponse($model->errors, 'No se pudo guardar', 500);
    }

    /**
     * find
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function find(int $id)
    {
        return $this->sendResponse(Agent::where('id', $id)->with('categories')->first());
    }

    /**
     * List
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->sendResponse(Agent::all());
    }

    /**
     * remove
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        return $this->sendResponse(Agent::query()->where('id', $id)->delete());
    }

    /**
     * Update
     * @param int id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => ['nullable', 'string'],
            'others' => ['nullable', 'string'],
            'nick' => ['nullable', 'string'],
            'agent_group_id' => ['nullable', 'integer'],
            'position' => ['nullable', 'array'],
            'position.lat' => ['sometimes', 'numeric'],
            'position.lng' => ['sometimes', 'numeric'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['sometimes', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $agent = Agent::find($id);
        if (!$agent) return $this->sendResponse(null, 'No encontrado', 400);
        $catArray = $validator['categories'];
        unset($validator['categories']);
        Agent::query()->where('id', $id)->update($validator);
        $agent = Agent::find($id);
        $agent->categories()->delete();
        $agent->categories()->attach($catArray);

        return $agent->save() ? $this->sendResponse($agent) : $this->sendResponse($agent->errors, 'No se pudo guardar', 500);
    }

    /**
     * Whoami
     * @return Illuminate\Http\JsonResponse
     */
    public function whoami()
    {
        return $this->sendResponse(auth()->user()->agent);
    }
}
