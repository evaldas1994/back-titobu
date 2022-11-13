<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Resources\user\UserResource;
use App\Http\Requests\auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function tokensCreate(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->input())) {
            $request->session()->regenerate();

            $user = Auth::user();

            return response()->json([
                'token' => $user->createToken('salt')->plainTextToken,
            ]);
        }

        return response()->json(['message'=> 'Unauthenticated.'], 401);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json(new UserResource($request->user()));
    }
}
