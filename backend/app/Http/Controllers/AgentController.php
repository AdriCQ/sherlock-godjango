<?php

namespace App\Http\Controllers;

use App\Models\Agent;
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:agents'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'others' => ['nullable', 'string'],
            'user_name' => ['required', 'string'],
            'password' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $validator['user_id'] = auth()->id();
        $validator['path'] = bcrypt($validator['user_name'] . $validator['password']);
        $catArray = $validator['categories'];
        unset($validator['categories']);
        $agent = new Agent($validator);
        $agent->save();
        $agent->categories()->attach($catArray);
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
}
