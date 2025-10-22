<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Cart;
use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = UserService::create($request, $validated);
        return ApiResponse::sendResponse(201, "Registered Successfully!", new UserResource($user));
    }

    public function login(LoginRequest $request)
    {
        $request->ensureIsNotRateLimited();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            RateLimiter::clear($request->throttleKey());
            return ApiResponse::sendResponse(200, "Login Successully", new UserResource($user));
        } else {
            RateLimiter::hit($request->throttleKey());
            return ApiResponse::sendResponse(401, "These credentials do not match our records.", null);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200, 'Logged Out Successfully');
    }
}
