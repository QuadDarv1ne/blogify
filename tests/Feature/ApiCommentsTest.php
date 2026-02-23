<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_approved_comments_for_post(): void
    {
        $post = Post::factory()->create();
        Comment::factory()->count(2)->create(['post_id' => $post->id, 'is_approved' => true]);
        Comment::factory()->create(['post_id' => $post->id, 'is_approved' => false]);

        $response = $this->getJson("/api/v1/posts/{$post->id}/comments");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }

    public function test_can_create_comment(): void
    {
        $post = Post::factory()->create();

        $response = $this->postJson("/api/v1/posts/{$post->id}/comments", [
            'author_name' => 'John Doe',
            'author_email' => 'john@example.com',
            'content' => 'Great post!',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Comment submitted for moderation',
            ]);

        $this->assertDatabaseHas('comments', [
            'author_name' => 'John Doe',
            'post_id' => $post->id,
            'is_approved' => false,
        ]);
    }

    public function test_comment_validation_fails(): void
    {
        $post = Post::factory()->create();

        $response = $this->postJson("/api/v1/posts/{$post->id}/comments", []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['author_name', 'author_email', 'content']);
    }
}
