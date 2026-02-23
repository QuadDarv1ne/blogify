<?php

namespace App\Providers;

use App\Services\TagService;
use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TagService::class, function ($app) {
            return new TagService();
        });
    }

    public function boot(): void
    {
        //
    }
}
