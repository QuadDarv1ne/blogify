<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PostService
{
    public function getPublished(int $perPage = 10): LengthAwarePaginator
    {
        return Cache::remember('posts.published.' . request('page', 1), 3600, function () use ($perPage) {
            return Post::with(['category', 'tags'])
                ->published()
                ->orderBy('published_at', 'desc')
                ->paginate($perPage);
        });
    }

    public function getBySlug(string $slug): ?Post
    {
        return Cache::remember("post.{$slug}", 3600, function () use ($slug) {
            return Post::with(['category', 'tags', 'comments'])
                ->where('slug', $slug)
                ->published()
                ->first();
        });
    }

    public function getPopular(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('posts.popular', 3600, function () use ($limit) {
            return Post::with(['category'])
                ->published()
                ->withCount('comments')
                ->orderBy('comments_count', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    public function create(array $data): Post
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        
        $post = Post::create($data);

        if (!empty($data['tags'])) {
            $tagIds = $this->syncTags($data['tags']);
            $post->tags()->sync($tagIds);
        }

        $this->clearCache();

        return $post;
    }

    public function update(Post $post, array $data): Post
    {
        if (isset($data['title']) && $data['title'] !== $post->title) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        }

        $post->update($data);

        if (array_key_exists('tags', $data)) {
            $tagIds = $this->syncTags($data['tags']);
            $post->tags()->sync($tagIds);
        }

        $this->clearCache();

        return $post;
    }

    public function delete(Post $post): void
    {
        $post->tags()->detach();
        $post->comments()->delete();
        $post->delete();
        
        $this->clearCache();
    }

    protected function syncTags(array $tags): array
    {
        $tagIds = [];
        
        foreach ($tags as $tag) {
            $tagModel = Tag::firstOrCreate(
                ['slug' => Str::slug($tag)],
                ['name' => $tag]
            );
            $tagIds[] = $tagModel->id;
        }
        
        return $tagIds;
    }

    protected function clearCache(): void
    {
        Cache::forget('posts.published.1');
        Cache::forget('posts.popular');
        Cache::flush();
    }
}
