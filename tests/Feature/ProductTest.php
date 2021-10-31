<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ProductTest extends TestCase

{
    Protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            factory(User::class)->create()
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApi()
    {
        $response = $this->getJson('api/v1');
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Welcome to the Todo API',
            'status' => 'Connected'
        ]);
    }

    /**
     * A basic feature test product index.
     *
     * @return void
     */
    public function testProductIndex()
    {
        Product::truncate();
        factory(Product::class, 100)->create();
        $response = $this->getJson('api/v1/products');
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertSuccessful();
        $response->assertJsonCount(100, 'data');
    }

    /**
     * A basic feature test product index.
     *
     * @return void
     */
    public function testProductCreate()
    {
        $data = [
            'price' =>  '101',
            'name'  =>  'Product Test'
        ];
        $response = $this->postJson('api/v1/products', $data);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertSuccessful();
        $this->assertDatabaseHas('products', $data);
    }

    public function testProductUpdate()
    {
        $data = [
            'price' =>  '100',
            'name'  =>  'Product Test'
        ];
        $product = factory(Product::class)->create($data);
        $data['name'] = 'Product Test Update';
        $response = $this->putJson("api/v1/products/$product->id", $data);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertSuccessful();
        $this->assertDatabaseHas('products', $data);
    }

    public function testProductShow()
    {
        $product = factory(Product::class)->create();
        $response = $this->getJson("api/v1/products/$product->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price
            ]
        ]);
    }

    public function testProductDelete()
    {
        $product = factory(Product::class)->create();
        $response = $this->deleteJson("api/v1/products/$product->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertSuccessful();
        $response->assertJson(['Producto eliminado!']);
        $this->assertDeleted($product);
    }
}
