<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Posts\CreatePostAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController
{
    public function __construct(
        private readonly CreatePostAction $createPostAction,
    ) {}

    public function store(Request $request): JsonResponse
    {
        return $this->createPostAction->handle($request);
    }
}
