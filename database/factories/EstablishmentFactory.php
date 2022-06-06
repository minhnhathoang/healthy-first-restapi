<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Establishment>
 */
class EstablishmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'owner' => $this->faker->name(),
            'telephone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'kind_of_business' => $this->faker->text(20),
            'description' => $this->faker->text(100)
        ];
    }
}
