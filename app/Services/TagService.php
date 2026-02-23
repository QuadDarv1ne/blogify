<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TagService
{
    public function getAll()
    {
        return Cache::remember('tags', 3600, function () {
            return Tag::all();
        });
    }

    public function getBySlug(string $slug): ?Tag
    {
        return Cache::remember("tag.{$slug}", 3600, function () use ($slug) {
            return Tag::where('slug', $slug)->first();
        });
    }

    public function create(array $data): Tag
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        
        $tag = Tag::create($data);
        
        Cache::forget('tags');

        return $tag;
    }

    public function update(Tag $tag, array $data): Tag
    {
        if (isset($data['name']) && $data['name'] !== $tag->name) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        }

        $tag->update($data);
        
        Cache::forget('tags');
        Cache::forget("tag.{$tag->slug}");

        return $tag;
    }

    public function delete(Tag $tag): void
    {
        $tag->posts()->detach();
        $tag->delete();
        
        Cache::forget('tags');
    }
}
