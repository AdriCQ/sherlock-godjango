<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors()->toArray(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $user = new User($validator);
        $user->save();
        return $this->sendResponse($user, 'Usuario creado', 201);
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
        $user->save();
        return $this->sendResponse([
            'profile' => $user,
            'api_token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }
}
