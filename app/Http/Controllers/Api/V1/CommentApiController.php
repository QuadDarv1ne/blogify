<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentApiController extends ApiController
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function index(int $postId): JsonResponse
    {
        $post = Post::findOrFail($postId);
        $comments = $this->commentService->getApprovedForPost($post);
        
        return $this->success($comments);
    }

    public function store(Request $request, int $postId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed', 422, $validator->errors());
        }

        $post = Post::findOrFail($postId);
        $comment = $this->commentService->create(array_merge(
            $validator->validated(),
            ['post_id' => $post->id]
        ));

        return $this->success($comment, 'Comment submitted for moderation', 201);
    }
}
