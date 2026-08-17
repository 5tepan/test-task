<?php

namespace App\Actions\Api\Auth;

use App\Http\Resources\AccessTokenResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterAction
{
    /**
     * @param  array{name: string, email: string, password: string}  $data
     */
    public function handle(array $data): AccessTokenResource
    {
        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                throw new HttpException(409, 'User already exists');
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

        return new AccessTokenResource([
            'access_token' => $user->createToken('api')->plainTextToken,
        ]);
    }
}
