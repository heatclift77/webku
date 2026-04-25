<?php

use App\Models\Product;
use App\Models\SalesPage;
use App\Models\User;
use Illuminate\Support\Facades\Http;

test('authenticated user can publish their sales page to netlify', function () {
    config()->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));

    putenv('NETLIFY_TOKEN=test-token');
    putenv('NETLIFY_SITE_ID=test-site-id');
    $_ENV['NETLIFY_TOKEN'] = 'test-token';
    $_ENV['NETLIFY_SITE_ID'] = 'test-site-id';
    $_SERVER['NETLIFY_TOKEN'] = 'test-token';
    $_SERVER['NETLIFY_SITE_ID'] = 'test-site-id';

    Http::fake([
        'https://api.netlify.com/api/v1/sites/test-site-id/deploys' => Http::response([
            'id' => 'deploy-123',
        ], 201),
        'https://api.netlify.com/api/v1/deploys/deploy-123/files/index.html' => Http::response([], 200),
        'https://api.netlify.com/api/v1/deploys/deploy-123' => Http::response([
            'ssl_url' => 'https://deploy-123--example.netlify.app',
        ], 200),
    ]);

    $user = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $user->id]);
    $salesPage = SalesPage::factory()->create([
        'product_id' => $product->id,
        'template' => 'modern',
        'published_url' => null,
    ]);

    $response = $this->actingAs($user)->post(route('sales-pages.publish', $salesPage));

    $response
        ->assertRedirect(route('products.show', $product))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('sales_pages', [
        'id' => $salesPage->id,
        'published_url' => 'https://deploy-123--example.netlify.app',
    ]);
});

test('user cannot publish sales page they do not own', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $otherUser->id]);
    $salesPage = SalesPage::factory()->create(['product_id' => $product->id]);

    $response = $this->actingAs($user)->post(route('sales-pages.publish', $salesPage));

    $response->assertStatus(403);
});
