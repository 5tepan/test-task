<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Auth\LoginAction;
use App\Actions\Api\Auth\RegisterAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController
{
    public function __construct(
        private readonly LoginAction $loginAction,
        private readonly RegisterAction $registerAction,
    ) {}

    public function login(Request $request): JsonResponse
    {
        return $this->loginAction->handle($request);
    }

    public function register(Request $request): JsonResponse
    {
        return $this->registerAction->handle($request);
    }
}
