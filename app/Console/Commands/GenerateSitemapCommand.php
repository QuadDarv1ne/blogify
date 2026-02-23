<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'blog:sitemap {--path= : Custom path for sitemap}';
    protected $description = 'Generate sitemap.xml';

    public function handle(): int
    {
        $posts = Post::published()->get();
        $categories = Category::all();
        
        $path = $this->option('path') ?? public_path('sitemap.xml');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

        // Home
        $xml .= $this->url(url('/'), now(), '1.0', 'daily');
        
        // Posts
        foreach ($posts as $post) {
            $xml .= $this->url(
                route('posts.show', $post->slug, false),
                $post->updated_at,
                '0.8',
                'weekly'
            );
        }

        // Categories
        foreach ($categories as $category) {
            $xml .= $this->url(
                route('home', ['category' => $category->slug], false),
                $category->updated_at,
                '0.6',
                'weekly'
            );
        }

        $xml .= '</urlset>';

        file_put_contents($path, $xml);
        
        $this->info("Sitemap generated at: {$path}");
        
        return self::SUCCESS;
    }

    protected function url(string $loc, $lastmod, string $priority, string $changefreq): string
    {
        return sprintf(
            "  <url>\n    <loc>%s</loc>\n    <lastmod>%s</lastmod>\n    <changefreq>%s</changefreq>\n    <priority>%s</priority>\n  </url>\n",
            $loc,
            $lastmod->format('c'),
            $changefreq,
            $priority
        );
    }
}
