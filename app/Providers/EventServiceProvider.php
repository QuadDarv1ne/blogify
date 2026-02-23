<?php

namespace App\Providers;

use App\Events\CommentSubmitted;
use App\Events\PostCreated;
use App\Events\PostPublished;
use App\Listeners\LogPostCreated;
use App\Listeners\SendCommentNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PostCreated::class => [
            LogPostCreated::class,
        ],
        PostPublished::class => [
            // Добавить listeners для публикации
        ],
        CommentSubmitted::class => [
            SendCommentNotification::class,
        ],
    ];

    public function boot(): void
    {
        Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\LogSuccessfulLogin::class
        );
    }
}
