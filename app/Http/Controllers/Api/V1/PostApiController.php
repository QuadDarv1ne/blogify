<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostApiController extends ApiController
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $posts = $this->postService->getPublished($request->get('per_page', 15));
        
        return $this->success($posts);
    }

    public function show(string $slug): JsonResponse
    {
        $post = $this->postService->getBySlug($slug);
        
        if (!$post) {
            return $this->error('Post not found', 404);
        }

        return $this->success($post);
    }

    public function popular(): JsonResponse
    {
        $posts = $this->postService->getPopular();
        return $this->success($posts);
    }
}
