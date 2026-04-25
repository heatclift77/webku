<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesPageController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

// Redirect to products for authenticated users
Route::redirect('/', '/products', 301);

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/generate', [ProductController::class, 'generate'])->name('products.generate');
    Route::patch('products/{product}/template', [ProductController::class, 'updateTemplate'])->name('products.template.update');
    Route::get('sales-pages/{salesPage}/export', [SalesPageController::class, 'exportHtml'])->name('sales-pages.export');
    Route::post('sales-pages/{salesPage}/publish', [SalesPageController::class, 'publish'])->name('sales-pages.publish');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public landing page route with dynamic template
Route::get('/sales-pages/{product}', function (Product $product) {
    $salesPage = $product->salesPage;
    if (! $salesPage) {
        abort(404, 'Sales page not found');
    }

    // Get the template, default to 'modern' if not set or doesn't exist
    $template = $salesPage->template ?? 'modern';
    $templatePath = "templates.{$template}";

    // Check if template view exists, fallback to modern
    if (! View::exists($templatePath)) {
        $templatePath = 'templates.modern';
    }

    return view($templatePath, compact('product', 'salesPage'));
})->name('sales-pages.show');

require __DIR__.'/auth.php';
