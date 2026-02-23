<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_published_posts(): void
    {
        Post::factory()->count(3)->create(['is_published' => true, 'published_at' => now()]);
        Post::factory()->create(['is_published' => false]);

        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data' => [
                        '*' => ['id', 'title', 'slug', 'content']
                    ]
                ]
            ]);
    }

    public function test_can_get_single_post_by_slug(): void
    {
        $post = Post::factory()->create([
            'slug' => 'test-post',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->getJson("/api/v1/posts/{$post->slug}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'slug' => 'test-post',
                ]
            ]);
    }

    public function test_returns_404_for_non_existent_post(): void
    {
        $response = $this->getJson('/api/v1/posts/non-existent');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Post not found',
            ]);
    }

    public function test_can_get_popular_posts(): void
    {
        $post = Post::factory()->create([
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->getJson('/api/v1/posts/popular');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }
}
