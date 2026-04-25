<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $product = \App\Models\Product::first();
        if (!$product) {
            $this->error('No products found');
            return;
        }

        $this->info('Testing generate for product: ' . $product->name);

        $aiService = app(\App\Services\AIService::class);
        $prompt = "Generate a sales page for the following product. Return ONLY a valid JSON object with these exact keys: headline, subheadline, description, benefits, features, pricing, cta. Each value should be a string.

IMPORTANT: Your response must be valid JSON that can be parsed. Do not include any text before or after the JSON. Start your response with { and end with }.

Product Name: {$product->name}
Description: {$product->description}
Features: " . implode(', ', $product->features ?? []) . "
Target Audience: {$product->target_audience}
Price: \${$product->price}
Unique Selling Proposition: {$product->usp}

Make the sales page compelling and persuasive.";

        try {
            $response = $aiService->generateSalesPage($prompt);
            $this->info('AI Response: ' . $response);

            $content = json_decode($response, true);
            if (!$content) {
                $this->error('Failed to decode JSON response');
                return;
            }

            $this->info('Decoded content: ' . json_encode($content));

            // Check if all required keys exist
            $requiredKeys = ['headline', 'subheadline', 'description', 'benefits', 'features', 'pricing', 'cta'];
            $missingKeys = [];
            foreach ($requiredKeys as $key) {
                if (!isset($content[$key]) || !is_string($content[$key])) {
                    $missingKeys[] = $key;
                }
            }

            if (!empty($missingKeys)) {
                $this->error('Missing or invalid keys: ' . implode(', ', $missingKeys));
            } else {
                $this->info('All required keys present!');

                // Save to database
                \App\Models\SalesPage::updateOrCreate(
                    ['product_id' => $product->id],
                    ['generated_content' => $content]
                );

                $this->info('Sales page saved successfully!');
            }

        } catch (\Exception $e) {
            $this->error('Exception: ' . $e->getMessage());
        }
    }
}
