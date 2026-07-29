<?php

namespace App\Actions\Api\Posts;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreatePostAction
{
    public function handle(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required', 'string'],
                'text' => ['required', 'string'],
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

        $user = $request->user();

        if (! $user instanceof User) {
            return response()->json(
                ['message' => 'Unauthenticated'],
                401,
            );
        }

        $data = $validator->validated();

        $post = Post::query()->create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'text' => $data['text'],
        ]);

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }
}
