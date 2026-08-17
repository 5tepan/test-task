<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Posts\CreatePostAction;
use App\Actions\Api\Posts\ListMyPostsAction;
use App\Actions\Api\Posts\ListPostsAction;
use App\Http\Requests\Api\Posts\ListPostsRequest;
use App\Http\Requests\Api\Posts\StorePostRequest;
use App\Models\User;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('Posts', weight: 1)]
class PostController
{
    public function __construct(
        private readonly CreatePostAction $createPostAction,
        private readonly ListPostsAction $listPostsAction,
        private readonly ListMyPostsAction $listMyPostsAction,
    ) {}

    /**
     * List blog posts with optional pagination, sorting, and date filters.
     */
    #[Endpoint(title: 'List posts', operationId: 'postsIndex')]
    #[Response(status: 422, description: 'Validation failed.')]
    public function index(ListPostsRequest $request): AnonymousResourceCollection
    {
        return $this->listPostsAction->handle($request);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return $this->createPostAction
            ->handle($user, $request->validated())
            ->response()
            ->setStatusCode(201);
    }

    public function mine(ListPostsRequest $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return $this->listMyPostsAction->handle($user, $request);
    }
}
