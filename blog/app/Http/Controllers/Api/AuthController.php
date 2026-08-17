<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Auth\LoginAction;
use App\Actions\Api\Auth\RegisterAction;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\AccessTokenResource;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\Response;
use Illuminate\Http\JsonResponse;

#[Group('Auth', weight: 0)]
class AuthController
{
    public function __construct(
        private readonly LoginAction $loginAction,
        private readonly RegisterAction $registerAction,
    ) {}

    /**
     * Authenticate an existing user and return a Sanctum access token.
     */
    #[Endpoint(title: 'Login', operationId: 'authLogin')]
    #[Response(status: 401, description: 'Invalid email or password.', type: 'array{message: string}')]
    #[Response(status: 422, description: 'Validation failed.')]
    public function login(LoginRequest $request): AccessTokenResource
    {
        return $this->loginAction->handle($request->validated());
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->registerAction
            ->handle($request->validated())
            ->response()
            ->setStatusCode(201);
    }
}
