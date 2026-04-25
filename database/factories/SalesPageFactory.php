<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SalesPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SalesPage>
 */
class SalesPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'template' => fake()->randomElement(['modern', 'minimal', 'startup']),
            'generated_content' => [
                'headline' => fake()->sentence(),
                'subheadline' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'benefits' => fake()->paragraph(),
                'features' => fake()->paragraph(),
                'pricing' => fake()->sentence(),
                'cta' => fake()->sentence(),
            ],
        ];
    }
}
