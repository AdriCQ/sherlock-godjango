<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            // 'agent_group_id' => ['required', 'integer'],
            'position' => ['nullable', 'array'],
            'position.lat' => ['sometimes', 'numeric'],
            'position.lng' => ['sometimes', 'numeric'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();

        $agentGroup = AgentGroup::query()->where('client_id', auth()->user()->client->id)->first();
        $validator['agent_group_id'] = $agentGroup->id;

        $user = User::find($validator['user_id']);
        if (!$user)
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
     * assignments
     */
    public function assignments(int $status = 0)
    {
        return $this->sendResponse(auth()->user()->agent->assignments()->where('status', $status)->get());
    }

    /**
     * List
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        if(!auth()->user()->client)
            return $this->sendResponse(null, 'Cliente no encontrado', 401);
        return $this->sendResponse(Agent::whereHas('user', function (Builder $query) {
            $query->where('client_id', auth()->user()->client->id);
        })->get());
    }

    /**
     * remove
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        // TODO: Any manager can delete any agent error
        return $this->sendResponse(Agent::query()->where(['id', $id])->delete());
    }

    /**
     * Search
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mode' => ['required', 'in:user,nick'],
            'search' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $agents = [];
        $clientId = auth()->user()->client->id;
        if ($validator['mode'] === 'user') {
            $users = User::query()
                ->where('client_id', auth()->user()->client->id)
                ->whereRaw('LOWER("name") LIKE ?', ['%' . trim(strtolower($validator['search'])) . '%'])
                ->orWhereRaw('LOWER("email") LIKE ?', ['%' . trim(strtolower($validator['search'])) . '%'])->with('agent')->get();
            foreach ($users as $user) {
                if ($user->agent)
                    array_push($agents, $user->agent);
            }
        } else {
            $agents = Agent::query()->whereRaw('LOWER("nick") LIKE ?', ['%' . trim(strtolower($validator['search'])) . '%'])->get();
        }
        return $this->sendResponse($agents);
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
            'bussy' => ['nullable', 'boolean'],
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
        // Check if belongs to same client
        if($agent->user->client->id !== auth()->user()->client->id)
            return $this->sendResponse(null, 'No tiene permisos', 401);
        // Update categories
        if (isset($validator['categories'])) {
            $catArray = $validator['categories'];
            unset($validator['categories']);
            $agent->categories()->delete();
            $agent->categories()->attach($catArray);
        }
        return $agent->update($validator)
            ? $this->sendResponse(Agent::find($id))
            : $this->sendResponse(null, 'No se pudo guardar', 500);
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
