<?php

namespace App\Http\Controllers\api\user;

use App\Http\Requests\user\UserStoreUpdateRequest;
use App\Http\Resources\user\userCollection;
use App\Http\Resources\user\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::simplePaginate();

        return response()->json(new userCollection($users));
    }

    public function store(UserStoreUpdateRequest $request): JsonResponse
    {
        $user = new User();
        $user->name = $request->validated('name');
        $user->password = Hash::make($request->validated('password'));
        $user->email = $request->input('email');
        $user->save();

        return response()->json(new UserResource($user), 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user));
    }

    public function update(UserStoreUpdateRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json(new UserResource($user));
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
