<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:agents'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'others' => ['nullable', 'string'],
            'user_name' => ['required', 'string'],
            'password' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'coordinate' => ['required', 'array'],
            'coordinate.lat' => ['required', 'numeric'],
            'coordinate.lng' => ['required', 'numeric'],
            'categories.*' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $validator['user_id'] = auth()->id();
        $validator['path'] = 'agents/' . hash('sha256', $validator['user_name'] . $validator['password']) . '.sd';
        $catArray = $validator['categories'];
        unset($validator['categories']);
        $agent = new Agent($validator);
        $agent->save();
        $agent->categories()->attach($catArray);
        // Create folders
        if (
            !Storage::makeDirectory($agent->path)
            || !Storage::makeDirectory($agent->path . '/routes')
            || !Storage::makeDirectory($agent->path . '/checkpoints')
            || !Storage::makeDirectory($agent->path . '/coordinates')
            || !Storage::makeDirectory($agent->path . '/observations')
        )
            return $this->sendResponse(null, 'Error creando arbol', 503);
        return $this->sendResponse($agent);
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
            'name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'others' => ['nullable', 'string'],
            'user_name' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer'],
            'coordinate' => ['nullable', 'array'],
            'coordinate.lat' => ['nullable', 'numeric'],
            'coordinate.lng' => ['nullable', 'numeric'],
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
        $agent->path =
            'agents/' . hash('sha256', $agent->user_name . $agent->password) . '.sd';
        $agent->categories()->delete();
        $agent->categories()->attach($catArray);
        $agent->save();
        return $this->sendResponse($agent);
    }
}
