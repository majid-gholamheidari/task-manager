<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Authentication\LoginRequest;
use App\Http\Requests\Api\V1\Authentication\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends MainController
{

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password'])))
            return $this->easyResponse(false, [], 401, 'Sorry... but we have no user with this email and password!');
        $user = User::where('email', $request->get('email'))->first();
        $result = ['user_token' => $user->createToken($this->createUserToken($user))->plainTextToken];
        return $this->easyResponse(true, $result, 200, 'Welcome back ' . $user->name);
    }

    /**
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
        $result = ['user_token' => $user->createToken($this->createUserToken($user))->plainTextToken];
        return $this->easyResponse(true, $result, 200, 'Well done. Your account created successfully.');
    }

    /**
     * @param User $user
     * @return string
     */
    private function createUserToken(User $user): string
    {
        return "API_TOKEN_V1_" . $user->email . '_' . now()->timestamp;
    }
}
