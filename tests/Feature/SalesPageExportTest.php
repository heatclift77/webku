<?php

use App\Models\Product;
use App\Models\SalesPage;
use App\Models\User;

test('authenticated user can export their sales page as HTML', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $user->id]);
    $salesPage = SalesPage::factory()->create([
        'product_id' => $product->id,
        'template' => 'modern',
        'generated_content' => [
            'headline' => 'Test Headline',
            'subheadline' => 'Test Subheadline',
            'description' => 'Test Description',
            'benefits' => 'Test Benefits',
            'features' => 'Test Features',
            'pricing' => 'Test Pricing',
            'cta' => 'Test CTA'
        ]
    ]);

    $response = $this->actingAs($user)
        ->get(route('sales-pages.export', $salesPage));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/html; charset=utf-8');
    $response->assertHeader('Content-Disposition', 'attachment; filename=sales-page-' . $salesPage->id . '.html');
});

test('user cannot export sales page they do not own', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $otherUser->id]);
    $salesPage = SalesPage::factory()->create(['product_id' => $product->id]);

    $response = $this->actingAs($user)
        ->get(route('sales-pages.export', $salesPage));

    $response->assertStatus(403);
});

test('unauthenticated user cannot export sales page', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $user->id]);
    $salesPage = SalesPage::factory()->create(['product_id' => $product->id]);

    $response = $this->get(route('sales-pages.export', $salesPage));

    $response->assertRedirect(route('login'));
});
