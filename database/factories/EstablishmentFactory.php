<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
        $type = ['Sản xuất thực phẩm', 'Dịch vụ ăn uống'];
        return [
            'name' => $this->faker->name(),
            'owner' => $this->faker->name(),
            'telephone' => $this->faker->phoneNumber(),
            'fax' => $this->faker->phoneNumber(),
            'address' => $this->faker->city().', '. DB::table('provinces')->inRandomOrder()->first()->name,
            'kind_of_business' => $type[rand(0, 1)],
            'description' => $this->faker->text(50)
        ];
    }
}
