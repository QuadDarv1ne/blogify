<?php

namespace App\Providers;

use App\Services\CommentService;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommentService::class, function ($app) {
            return new CommentService();
        });
    }

    public function boot(): void
    {
        //
    }
}
