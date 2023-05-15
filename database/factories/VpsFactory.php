<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vps>
 */
class VpsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'server_name' => $this->faker->unique()->sentance(),
            'description' => $this->faker->text(),
            'instance' => $this->faker->randomElement(['low','mediom','high'])
        ];
    }
}
