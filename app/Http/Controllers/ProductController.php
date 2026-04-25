<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\SalesPage;
use App\Services\AIService;

class ProductController extends Controller
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = auth()->user()->products()->latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['features'] = $this->formatFeatures($data['features']);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

        $salesPage = $product->salesPage;

        return view('products.show', compact('product', 'salesPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $data = $request->validated();
        $data['features'] = $this->formatFeatures($data['features']);

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Generate sales page for the product.
     */
    public function generate(Product $product)
    {
        $this->authorize('update', $product);

        $prompt = $this->buildPrompt($product);

        try {
            $response = $this->aiService->generateSalesPage($prompt);
            $content = json_decode($response, true);
            if (!$this->isValidSalesPageContent($content)) {
                // Retry once
                $response = $this->aiService->generateSalesPage($prompt);
                $content = json_decode($response, true);

                if (!$this->isValidSalesPageContent($content)) {
                    return redirect()->route('products.index')->with('error', 'Failed to generate valid sales page content. Please try again.');
                }
            }

            // Save or update sales page
            SalesPage::updateOrCreate(
                ['product_id' => $product->id],
                ['generated_content' => $content]
            );

            return redirect()->route('products.show', $product)->with('success', 'Sales page generated successfully.');

        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to generate sales page: ' . $e->getMessage());
        }
    }

    protected function buildPrompt(Product $product): string
    {
        return "Generate a sales page for the following product. Return ONLY a valid JSON object with these exact keys: headline, subheadline, description, benefits, features, pricing, cta. Each value should be a string.

IMPORTANT: Your response must be valid JSON that can be parsed. Do not include any text before or after the JSON. Start your response with { and end with }.

Product Name: {$product->name}
Description: {$product->description}
Features: " . implode(', ', $product->features ?? []) . "
Target Audience: {$product->target_audience}
Price: \${$product->price}
Unique Selling Proposition: {$product->usp}

Make the sales page compelling and persuasive.";
    }

    protected function isValidSalesPageContent($content): bool
    {
        if (!is_array($content)) {
            return false;
        }

        $requiredKeys = ['headline', 'subheadline', 'description', 'benefits', 'features', 'pricing', 'cta'];

        foreach ($requiredKeys as $key) {
            if (!isset($content[$key]) || !is_string($content[$key])) {
                return false;
            }
        }

        return true;
    }

    protected function formatFeatures(string $features): array
    {
        return array_values(array_filter(array_map(fn ($feature) => trim($feature), explode(',', $features)), fn ($feature) => $feature !== ''));
    }

    public function updateTemplate(Product $product)
    {
        $this->authorize('update', $product);

        $validated = request()->validate([
            'template' => 'required|string|in:modern,minimal,startup',
        ]);

        if (!$product->salesPage) {
            return redirect()->route('products.show', $product)->with('error', 'No sales page generated yet.');
        }

        $product->salesPage->update(['template' => $validated['template']]);

        return redirect()->route('products.show', $product)->with('success', 'Template updated successfully.');
    }
}
