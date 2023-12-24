<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Authentication\LoginRequest;
use App\Http\Requests\Api\V1\Authentication\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends MainController
{

    /**
     * Login user
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password'])))
            return $this->easyResponse(false, [], 401, 'Sorry... but we have no user with this email and password!');
        $user = User::where('email', $request->get('email'))->first();
        $user->tokens()->delete();
        return $this->easyResponse(true, new UserResource($user), 200, 'Welcome back ' . $user->name);
    }

    /**
     * Register new user
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        return $this->easyResponse(true, new UserResource($user), 200, 'Well done. Your account created successfully.');
    }

    /**
     * Sign out method
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->easyResponse(true, [], 200, 'You have been signed out. Come Back soon pls :)');
    }
}
