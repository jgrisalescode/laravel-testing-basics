<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function home_page_contains_empty_table(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee(__('No products found'));
    }

    /** @test */
    public function home_page_contains_non_empty_table(): void
    {
        Product::create([
            'name' => 'Product 1',
            'price' => 123
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Product 1',
            'price' => 123
        ]);
    }
}
