<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function created(Post $post): void
    {
        $this->clearCache();
    }

    public function updated(Post $post): void
    {
        $this->clearCache();
        Cache::forget("post.{$post->slug}");
    }

    public function deleted(Post $post): void
    {
        $this->clearCache();
        Cache::forget("post.{$post->slug}");
    }

    public function restored(Post $post): void
    {
        $this->clearCache();
    }

    public function forceDeleted(Post $post): void
    {
        $this->clearCache();
        Cache::forget("post.{$post->slug}");
    }

    protected function clearCache(): void
    {
        Cache::forget('posts.published.1');
        Cache::forget('posts.popular');
    }
}
