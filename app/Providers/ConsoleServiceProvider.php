<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ClearAllCacheCommand;
use App\Console\Commands\GenerateSitemapCommand;
use App\Console\Commands\SeedDemoDataCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $commands = [
        ClearAllCacheCommand::class,
        GenerateSitemapCommand::class,
        SeedDemoDataCommand::class,
    ];

    public function register(): void
    {
        $this->commands($this->commands);
    }

    public function boot(): void
    {
        //
    }
}
