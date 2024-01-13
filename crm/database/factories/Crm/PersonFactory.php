<?php

namespace Database\Factories\Crm;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crm\Person>
 */
class PersonFactory extends Factory
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
            'surname' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => random_int(1, 100),
        ];
    }
}
