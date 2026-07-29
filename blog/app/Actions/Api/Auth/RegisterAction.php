<?php

namespace App\Actions\Api\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterAction
{
    public function handle(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }

        $data = $validator->validated();

        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                return response()->json(
                    ['message' => 'User already exists'],
                    409,
                );
            }

            $user->update([
                'name' => $data['name'],
                'password' => $data['password'],
            ]);
        } else {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ], 201);
    }
}
