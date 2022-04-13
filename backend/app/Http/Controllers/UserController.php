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
     * Update Password
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed']
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->toArray());
        }
        $validator = $validator->validate();
        $user = User::query()->find(auth()->id());
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
