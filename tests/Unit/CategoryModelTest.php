<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created(): void
    {
        $category = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Tech posts',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Technology',
            'slug' => 'technology',
        ]);
    }

    public function test_category_slug_is_auto_generated(): void
    {
        $category = Category::create([
            'name' => 'Web Development',
        ]);

        $this->assertEquals('web-development', $category->slug);
    }

    public function test_category_can_have_posts(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($category->posts->contains($post));
    }

    public function test_category_posts_count(): void
    {
        $category = Category::factory()->create();
        Post::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertEquals(3, $category->posts->count());
    }
}
