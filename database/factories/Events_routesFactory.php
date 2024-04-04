<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Events_routesFactory extends Factory
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
            'date'=>fake()->date(),
            'kms'=>rand(100,400),
            'img'=>fake()->url(),
            'participants' => rand(10,120),
            'maps'=>fake()->city(),
        ];
    }
}
