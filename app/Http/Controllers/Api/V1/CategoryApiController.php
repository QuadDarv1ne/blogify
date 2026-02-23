<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends ApiController
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAll();
        return $this->success($categories);
    }

    public function show(string $slug): JsonResponse
    {
        $category = $this->categoryService->getBySlug($slug);
        
        if (!$category) {
            return $this->error('Category not found', 404);
        }

        return $this->success($category);
    }

    public function posts(string $slug): JsonResponse
    {
        $category = $this->categoryService->getBySlug($slug);
        
        if (!$category) {
            return $this->error('Category not found', 404);
        }

        $posts = $category->posts()
            ->published()
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return $this->success($posts);
    }
}
