<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class messagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => rand(1,10),
            'name'=>fake()->name(),
            'last_name'=>fake()->lastName(),
            'data'=>fake()->address(),
            'message'=>fake()->address(),
        ];
    }
}
