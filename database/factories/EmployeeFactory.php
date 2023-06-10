<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'full_name' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'email' => $this->faker->safeEmail,
            'department_id' => Department::factory(),
            'job_title' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'payment_type' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'salary' => $this->faker->randomNumber(),
            'hourly_rate' => $this->faker->randomNumber(),
        ];
    }
}
