<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        Cache::forget('posts.popular');
    }

    public function updated(Comment $comment): void
    {
        Cache::forget('posts.popular');
    }

    public function deleted(Comment $comment): void
    {
        Cache::forget('posts.popular');
    }

    public function restored(Comment $comment): void
    {
        Cache::forget('posts.popular');
    }

    public function forceDeleted(Comment $comment): void
    {
        Cache::forget('posts.popular');
    }
}
