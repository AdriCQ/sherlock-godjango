<?php

namespace App\Http\Controllers;

use App\Models\PersonalGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalGroupController extends Controller
{
    /**
     * Add user
     * @param int $id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function addUser(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer']
        ]);
        $group = PersonalGroup::find($id);
        if ($validator->fails() || !$group) {
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        $user = User::query()->find($validator['user_id']);
        if (!$user)
            return $this->sendResponse(null, 'Verifique los datos enviados', 400);
        $user->group_id = $id;
        if ($user->save()) {
            $group->users;
            return $this->sendResponse(['user' => $user, 'group' => $group]);
        }
        return $this->sendResponse($user->errors, 'No se pudo guardar', 503);
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
        $model = new PersonalGroup($validator);
        return $model->save() ? $this->sendResponse($model, null) : $this->sendResponse($model->errors, 'No se pudo guardar el Grupo', 400);
    }

    /**
     * List
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->sendResponse(PersonalGroup::query()->with('users')->get());
    }
    /**
     * Remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        return PersonalGroup::find($id) && PersonalGroup::find($id)->delete() ? $this->sendResponse(null, 'Eliminado correctamente') : $this->sendResponse(null, null, 503);
    }

    /**
     * removeUser
     * @param int $id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function removeUser(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer']
        ]);
        $group = PersonalGroup::find($id);
        if ($validator->fails() || !$group) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $user = User::query()->find($validator['user_id']);
        if (!$user)
            return $this->sendResponse(null, 'Verifique los s enviados', 400);
        $user->group_id = 1;
        $user->save();
        $group->users;
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
        $model = PersonalGroup::find($id);
        if ($validator->fails() || !$model) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        if ($model->update($validator)) {
            $model->users;
            return $this->sendResponse($model, null);
        }
        return $this->sendResponse($model->errors, 'No se pudo guardar el Grupo', 503);
    }
}
