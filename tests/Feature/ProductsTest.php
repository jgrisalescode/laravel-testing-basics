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
        $product = Product::create([
            'name' => 'Product 1',
            'price' => 123
        ]);

        $response = $this->get('/products');

        // Way to ensure that is into DB
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Product 1',
            'price' => 123
        ]);

        // Use instead assertSee because of possible false positive
        $response->assertViewHas('products', function ($collection) use ($product) {
            return $collection->contains($product);
        });
    }

    /** @test */
    public function paginate_product_table_doesnt_contain_11th_record()
    {
        for ($i = 1; $i <= 11; $i++){
            $product = Product::create([
                'name' => "Product {$i}",
                'price' => rand(100, 999)
            ]);
        }

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($collection) use ($product) {
            return !$collection->contains($product);
        });
    }

    /** @test */
    public function paginate_product_table_doesnt_contain_11th_record_using_factories()
    {
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();
        // dd($products);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
    }
}
