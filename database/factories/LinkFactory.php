<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class LinkFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'notes' => fake()->paragraph(),
            'meta_description' => fake()->paragraph(),
            'meta_author' => fake()->name(),
            'meta_keyword' => fake()->word(),
            'theme_color' => fake()->color(),
            'favicon' => null,
            'og_title' => fake()->sentence(),
            'og_description' => fake()->text(),
            'og_type' => fake()->word(),
            'og_url' => fake()->url(),
            'og_image' => fake()->url(),
            'og_site_name' => fake()->name(),
            'is_archived' => fake()->boolean(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'email_verified_at' => null,
            ],
        );
    }
}
