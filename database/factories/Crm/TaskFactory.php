<?php

namespace Database\Factories\Crm;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crm\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start_date = $this->faker->dateTimeBetween('-3 days', '+3 days');
        $end_date = $this->faker->dateTimeBetween(
            $start_date->format('Y-m-d H:i:s').' +3 days',
            $start_date->format('Y-m-d H:i:s').' +3 days'
        );

        return [
            'title' => $this->faker->title,
            'description' => $this->faker->text(),
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
