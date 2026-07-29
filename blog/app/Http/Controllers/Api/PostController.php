<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Posts\CreatePostAction;
use App\Actions\Api\Posts\ListMyPostsAction;
use App\Actions\Api\Posts\ListPostsAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController
{
    public function __construct(
        private readonly CreatePostAction $createPostAction,
        private readonly ListPostsAction $listPostsAction,
        private readonly ListMyPostsAction $listMyPostsAction,
    ) {}

    public function index(Request $request): JsonResponse
    {
        return $this->listPostsAction->handle($request);
    }

    public function store(Request $request): JsonResponse
    {
        return $this->createPostAction->handle($request);
    }

    public function mine(Request $request): JsonResponse
    {
        return $this->listMyPostsAction->handle($request);
    }
}
