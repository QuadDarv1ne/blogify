<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\TagService;
use Illuminate\Http\JsonResponse;

class TagApiController extends ApiController
{
    public function __construct(
        protected TagService $tagService
    ) {}

    public function index(): JsonResponse
    {
        $tags = $this->tagService->getAll();
        return $this->success($tags);
    }

    public function show(string $slug): JsonResponse
    {
        $tag = $this->tagService->getBySlug($slug);
        
        if (!$tag) {
            return $this->error('Tag not found', 404);
        }

        return $this->success($tag);
    }

    public function posts(string $slug): JsonResponse
    {
        $tag = $this->tagService->getBySlug($slug);
        
        if (!$tag) {
            return $this->error('Tag not found', 404);
        }

        $posts = $tag->posts()
            ->published()
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return $this->success($posts);
    }
}
