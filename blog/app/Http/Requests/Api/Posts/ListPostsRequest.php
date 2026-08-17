<?php

namespace App\Http\Requests\Api\Posts;

use Illuminate\Foundation\Http\FormRequest;

class ListPostsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            /**
             * How many posts to return.
             *
             * @default 10
             *
             * @example 10
             */
            'limit' => ['sometimes', 'integer', 'min:1'],
            /**
             * How many posts to skip.
             *
             * @default 0
             *
             * @example 0
             */
            'offset' => ['sometimes', 'integer', 'min:0'],
            /**
             * Sort mode: `date` (newest first) or `title` (A–Z).
             *
             * @default date
             *
             * @example date
             */
            'sort' => ['sometimes', 'string', 'in:date,title'],
            /**
             * Include posts created on or after this date (`Y-m-d`).
             *
             * @example 2026-01-01
             */
            'from' => ['sometimes', 'date'],
            /**
             * Include posts created on or before this date (`Y-m-d`).
             *
             * @example 2026-12-31
             */
            'to' => ['sometimes', 'date'],
        ];
    }

    public function limit(): int
    {
        return (int) ($this->validated('limit') ?? 10);
    }

    public function offset(): int
    {
        return (int) ($this->validated('offset') ?? 0);
    }

    public function sort(): string
    {
        return $this->validated('sort') ?? 'date';
    }
}
