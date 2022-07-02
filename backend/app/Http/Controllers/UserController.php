<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Models\Role;

class UserController extends Controller
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
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['nullable', 'string'],
            'password' => ['required', 'string', 'confirmed'],
            'role_id' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors()->toArray(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $role = Role::find($validator['role_id']);
        if (!$role) return $this->sendResponse(null, 'No existe el rol', 400);
        unset($validator['role_id']);
        $validator['password'] = bcrypt($validator['password']);
        $user = new User($validator);
        if ($user->save()) {
            $user->assignRole($role->name);
            $user->role;
            return $this->sendResponse($user, 'Usuario creado', 201);
        }
        return $this->sendResponse($user->errors, 'No se pudo crear el usuario', 502);
    }

    /**
     * List
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        // $roleId = Role::query()->where('name', 'user')->first();
        return $this->sendResponse(User::query()->where('id', '>', 2)->with(['role'])->get());
    }

    /**
     * List Roles
     * @return Illuminate\Http\JsonResponse
     */
    public function listRoles()
    {
        return $this->sendResponse(Role::all());
    }

    /**
     * Current
     * @return Illuminate\Http\JsonResponse
     */
    public function current()
    {
        return $this->sendResponse(auth()->user());
    }
    /**
     * login
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        if (!Auth::attempt($validator)) return $this->sendAuthError();
        $user = Auth::user();
        $user->role;
        return $this->sendResponse([
            'profile' => $user,
            'api_token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }

    /**
     * Remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        return  User::find($id) && User::find($id)->delete() ? $this->sendResponse() : $this->sendResponse(null, 'Usuario no encontrado', 400);
    }

    /**
     * Update
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            // 'email' => ['nullable', 'email', 'unique:users'],
            'phone' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'role_id' => ['nullable', 'integer']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        $user = User::find($id);
        if (!$user) return $this->sendResponse(null, 'No existe el usuario', 400);
        if (isset($validator['password'])) $validator['password'] = bcrypt($validator['password']);
        $user->update($validator);
        // Update Role
        if (isset($validator['role_id'])) {
            $role = Role::find($validator['role_id']);
            if (!$role) return $this->sendResponse(null, 'No existe el rol', 400);
            unset($validator['role_id']);
            $user->assignRole($role->name);
        }
        $user->role;
        return $this->sendResponse($user, 'Usuario actualizado');
    }

    /**
     * Update
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function updateEmail(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:users'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        $user = User::find($id);
        if (!$user) return $this->sendResponse(null, 'No existe el usuario', 400);
        if (isset($validator['password'])) $validator['password'] = bcrypt($validator['password']);
        $user->update($validator);
        // Update Role
        if (isset($validator['role_id'])) {
            $role = Role::find($validator['role_id']);
            if (!$role) return $this->sendResponse(null, 'No existe el rol', 400);
            unset($validator['role_id']);
            $user->assignRole($role->name);
        }
        $user->role;
        return $this->sendResponse($user, 'Usuario actualizado');
    }

    /**
     * Update Password
     * @param int id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function updatePassword(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $user = User::query()->find($id);
        if (!$user) return $this->sendAuthError();
        if (!Hash::check($validator['current_password'], $user->password))
            return $this->sendAuthError();
        $user->password = bcrypt($validator['password']);
        $user->tokens()->delete();
        return $user->save()
            ? $this->sendResponse([
                'profile' => $user,
                'api_token' => $user->createToken('auth-token')->plainTextToken
            ])
            : $this->sendResponse($user->errors, 'Error guardando usuario', 502);
    }
}
