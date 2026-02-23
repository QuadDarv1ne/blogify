<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAll()
    {
        return Category::getCached();
    }

    public function getBySlug(string $slug): ?Category
    {
        return Cache::remember("category.{$slug}", 3600, function () use ($slug) {
            return Category::where('slug', $slug)->first();
        });
    }

    public function create(array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        
        $category = Category::create($data);
        
        Cache::forget('categories');

        return $category;
    }

    public function update(Category $category, array $data): Category
    {
        if (isset($data['name']) && $data['name'] !== $category->name) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        }

        $category->update($data);
        
        Cache::forget('categories');
        Cache::forget("category.{$category->slug}");

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->posts()->update(['category_id' => null]);
        $category->delete();
        
        Cache::forget('categories');
    }
}
