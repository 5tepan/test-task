<?php

namespace App\Actions\Api\Auth;

use App\Http\Resources\AccessTokenResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginAction
{
    /**
     * @param  array{email: string, password: string}  $data
     */
    public function handle(array $data): AccessTokenResource
    {
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new HttpException(401, 'Invalid credentials');
        }

        return new AccessTokenResource([
            'access_token' => $user->createToken('api')->plainTextToken,
        ]);
    }
}
