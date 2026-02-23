<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_can_be_created(): void
    {
        $post = Post::factory()->create();
        
        $comment = Comment::create([
            'post_id' => $post->id,
            'author_name' => 'John Doe',
            'author_email' => 'john@example.com',
            'content' => 'Test comment',
        ]);

        $this->assertDatabaseHas('comments', [
            'author_name' => 'John Doe',
            'content' => 'Test comment',
        ]);
    }

    public function test_comment_belongs_to_post(): void
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $this->assertTrue($comment->post->is($post));
    }

    public function test_comment_can_belong_to_user(): void
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($comment->user->is($user));
    }

    public function test_comment_scope_approved(): void
    {
        $approvedComment = Comment::factory()->create(['is_approved' => true]);
        $pendingComment = Comment::factory()->create(['is_approved' => false]);

        $approved = Comment::approved()->get();

        $this->assertTrue($approved->contains($approvedComment));
        $this->assertFalse($approved->contains($pendingComment));
    }

    public function test_default_comment_is_not_approved(): void
    {
        $post = Post::factory()->create();
        $comment = Comment::create([
            'post_id' => $post->id,
            'author_name' => 'Test',
            'author_email' => 'test@test.com',
            'content' => 'Test',
        ]);

        $this->assertFalse($comment->is_approved);
    }
}
