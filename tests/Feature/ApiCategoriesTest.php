<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_categories(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }

    public function test_can_get_category_by_slug(): void
    {
        $category = Category::factory()->create(['slug' => 'technology']);

        $response = $this->getJson('/api/v1/categories/technology');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'slug' => 'technology',
                ]
            ]);
    }

    public function test_returns_404_for_non_existent_category(): void
    {
        $response = $this->getJson('/api/v1/categories/non-existent');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Category not found',
            ]);
    }
}
