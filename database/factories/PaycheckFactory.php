<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Paycheck;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaycheckFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Paycheck::class;

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
            'net_amount' => $this->faker->randomNumber(),
            'payed_at' => $this->faker->dateTime(),
        ];
    }
}
