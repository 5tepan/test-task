<?php

namespace App\Actions\Api\Posts;

use App\Http\Requests\Api\Posts\ListPostsRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListMyPostsAction
{
    public function handle(User $user, ListPostsRequest $request): AnonymousResourceCollection
    {
        $query = Post::query()->where('user_id', $user->id);

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->validated('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->validated('to'));
        }

        if ($request->sort() === 'title') {
            $query->orderBy('title');
        } else {
            $query->orderByDesc('created_at');
        }

        $posts = $query
            ->offset($request->offset())
            ->limit($request->limit())
            ->get();

        return PostResource::collection($posts);
    }
}
