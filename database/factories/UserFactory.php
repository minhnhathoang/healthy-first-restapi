<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $password = bcrypt('password');
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => 1,
            'location' => DB::table('provinces')->inRandomOrder()->first()->name,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->date(),
            'password' => $password,
            'remember_token' => Str::random(10),
            'avatar' => "images/avatar.png",
            'surname' => $this->faker->lastName(),
            'address' => $this->faker->address(),
            'gender' => rand(0, 1),
            'birthday' => $this->faker->date(),
            'mobile' => $this->faker->phoneNumber()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
