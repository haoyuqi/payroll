<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\TimeLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'employee_id' => Employee::factory(),
            'started_at' => $this->faker->dateTime(),
            'stopped_at' => $this->faker->dateTime(),
            'minutes' => $this->faker->randomNumber(),
        ];
    }
}
