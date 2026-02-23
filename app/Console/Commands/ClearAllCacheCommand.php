<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAllCacheCommand extends Command
{
    protected $signature = 'blog:clear-cache {--all : Clear all caches}';
    protected $description = 'Clear application cache and optimize';

    public function handle(): int
    {
        $this->info('Clearing caches...');

        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('event:clear');
        $this->call('clear-compiled');

        if ($this->option('all')) {
            $this->call('optimize:clear');
        }

        $this->info('All caches cleared successfully!');
        
        return self::SUCCESS;
    }
}
