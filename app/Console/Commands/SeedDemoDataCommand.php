<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Console\Command;

class SeedDemoDataCommand extends Command
{
    protected $signature = 'blog:seed-demo {--clean : Clean existing data before seeding}';
    protected $description = 'Seed demo data for the blog';

    public function handle(): int
    {
        if ($this->option('clean')) {
            $this->call('migrate:fresh', ['--seed' => true]);
            $this->info('Database refreshed with seed data.');
            return self::SUCCESS;
        }

        // Create admin if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        // Create categories
        $categories = [
            ['name' => 'Technology', 'description' => 'Tech news and tutorials'],
            ['name' => 'Laravel', 'description' => 'Laravel framework articles'],
            ['name' => 'JavaScript', 'description' => 'JavaScript tutorials'],
            ['name' => 'DevOps', 'description' => 'DevOps and infrastructure'],
            ['name' => 'Career', 'description' => 'Career advice'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => str()->slug($cat['name'])], $cat);
        }

        // Create tags
        $tags = ['PHP', 'Laravel', 'Vue', 'React', 'Docker', 'AWS', 'Git', 'API', 'REST', 'Testing'];
        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => str()->slug($tag)], ['name' => $tag]);
        }

        // Create sample posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel 12',
                'slug' => 'getting-started-laravel-12',
                'content' => "Laravel 12 brings exciting new features and improvements. In this article, we'll explore what's new and how to get started.\n\n## New Features\n\n- Improved performance\n- Simplified routing\n- Better error handling\n\n## Installation\n\n```bash\ncomposer create-project laravel/laravel my-app\n```",
                'excerpt' => 'Learn how to get started with Laravel 12',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Building REST APIs with Laravel',
                'slug' => 'building-rest-apis-laravel',
                'content' => 'REST APIs are the backbone of modern web applications. Learn how to build them with Laravel.',
                'excerpt' => 'A comprehensive guide to building REST APIs',
                'is_published' => true,
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Docker for PHP Developers',
                'slug' => 'docker-for-php-developers',
                'content' => 'Docker simplifies development environment setup. This guide covers Docker essentials for PHP developers.',
                'excerpt' => 'Master Docker for PHP development',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::firstOrCreate(
                ['slug' => $postData['slug']],
                array_merge($postData, ['user_id' => $admin->id, 'category_id' => 1])
            );
            
            // Attach random tags
            $post->tags()->sync(Tag::inRandomOrder()->limit(3)->pluck('id'));
        }

        $this->info('Demo data seeded successfully!');
        $this->line('Admin: admin@example.com / password');

        return self::SUCCESS;
    }
}
