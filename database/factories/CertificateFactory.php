<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = 0;
        return [
            'establishment_id' => rand(2, 400),
            'registration_number' => $this->faker->randomNumber(5),
            'date_issued' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'is_revoked' => rand(0, rand(0, rand(0, 1)))
        ];
    }
}
