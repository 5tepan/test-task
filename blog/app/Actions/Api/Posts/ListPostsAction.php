<?php

namespace App\Actions\Api\Posts;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListPostsAction
{
    public function handle(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->query(),
            [
                'limit' => ['sometimes', 'integer', 'min:1'],
                'offset' => ['sometimes', 'integer', 'min:0'],
                'sort' => ['sometimes', 'string', 'in:date,title'],
                'from' => ['sometimes', 'date'],
                'to' => ['sometimes', 'date'],
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

        $data = $validator->validated();

        $limit = $data['limit'] ?? 10;
        $offset = $data['offset'] ?? 0;
        $sort = $data['sort'] ?? 'date';

        $query = Post::query();

        if (isset($data['from'])) {
            $query->whereDate('created_at', '>=', $data['from']);
        }

        if (isset($data['to'])) {
            $query->whereDate('created_at', '<=', $data['to']);
        }

        if ($sort === 'title') {
            $query->orderBy('title');
        } else {
            $query->orderByDesc('created_at');
        }

        $posts = $query
            ->offset($offset)
            ->limit($limit)
            ->get();

        return PostResource::collection($posts)->response();
    }
}
