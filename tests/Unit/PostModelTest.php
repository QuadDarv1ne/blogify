<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_can_be_created(): void
    {
        $user = User::factory()->create();
        
        $post = Post::create([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Test content',
            'user_id' => $user->id,
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'slug' => 'test-post',
        ]);
    }

    public function test_post_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($post->category->is($category));
    }

    public function test_post_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($post->user->is($user));
    }

    public function test_post_can_have_tags(): void
    {
        $post = Post::factory()->create();
        $tag = Tag::factory()->create();

        $post->tags()->attach($tag);

        $this->assertTrue($post->tags->contains($tag));
    }

    public function test_post_scope_published(): void
    {
        $publishedPost = Post::factory()->create(['is_published' => true, 'published_at' => now()]);
        $draftPost = Post::factory()->create(['is_published' => false]);

        $published = Post::published()->get();
        
        $this->assertTrue($published->contains($publishedPost));
        $this->assertFalse($published->contains($draftPost));
    }

    public function test_post_reading_time_calculation(): void
    {
        $post = Post::factory()->create([
            'content' => str_repeat('word ', 400), // ~400 words = 2 min
        ]);

        $this->assertEquals(2, $post->reading_time);
    }
}
