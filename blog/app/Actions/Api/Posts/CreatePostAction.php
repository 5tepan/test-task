<?php

namespace App\Actions\Api\Posts;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

class CreatePostAction
{
    /**
     * @param  array{title: string, text: string}  $data
     */
    public function handle(User $user, array $data): PostResource
    {
        $post = Post::query()->create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'text' => $data['text'],
        ]);

        return new PostResource($post);
    }
}
