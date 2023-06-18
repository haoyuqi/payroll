<?php

use App\Enums\PaymentTypes;
use App\Models\Employee;
use App\Models\TimeLog;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\travelTo;

it('should create paychecks for salary employees', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $employees = Employee::factory()
        ->count(2)
        ->sequence(
            [
                'salary' => 50000 * 100,
                'payment_type' => PaymentTypes::SALARY->value,
            ],
            [
                'salary' => 70000 * 100,
                'payment_type' => PaymentTypes::SALARY->value,
            ],
        )->create();

    postJson(route('payday.store'))
        ->assertNoContent();

    assertDatabaseHas('paychecks', [
        'employee_id' => $employees[0]->id,
        'net_amount' => 416666,
    ]);
    assertDatabaseHas('paychecks', [
        'employee_id' => $employees[1]->id,
        'net_amount' => 583333,
    ]);
});

it('should create paychecks for hourly rate employees', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    travelTo(Carbon::parse('2022-02-10'), function () {
        $employee = Employee::factory([
            'hourly_rate' => 10 * 100,
            'payment_type' => PaymentTypes::HOURLY_RATE->value,
        ])->create();

        $dayBeforeYesterday = now()->subDays(2); // 2022-02-08 00:00:00
        $yesterday = now()->subDay(); // 2022-02-09 00:00:00
        $today = now();  // 2022-02-10 00:00:00

        TimeLog::factory()
            ->count(3)
            ->sequence(
                [
                    'employee_id' => $employee,
                    'minutes' => 90,
                    'started_at' => $dayBeforeYesterday,  // 2022-02-08 00:00:00
                    'stopped_at' => $dayBeforeYesterday->copy()->addMinutes(90), // 2022-02-08 01:30:00
                ],
                [
                    'employee_id' => $employee,
                    'minutes' => 15,
                    'started_at' => $yesterday,  // 2022-02-09 00:00:00
                    'stopped_at' => $yesterday->copy()->addMinutes(15), // 2022-02-08 00:15:00
                ],
                [
                    'employee_id' => $employee,
                    'minutes' => 51,
                    'started_at' => $today,  // 2022-02-10 00:00:00
                    'stopped_at' => $today->copy()->addMinutes(51),  // 2022-02-10 00:51:00
                ],
            )
            ->create();

        postJson(route('payday.store'))
            ->assertNoContent();

        $this->assertDatabaseHas('paychecks', [
            'employee_id' => $employee->id,
            'net_amount' => 30 * 100,
        ]);
    });
});

it('should create paychecks for hourly rate employees only for current month', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    travelTo(Carbon::parse('2022-02-10'), function () {
        $employee = Employee::factory([
            'hourly_rate' => 10 * 100,
            'payment_type' => PaymentTypes::HOURLY_RATE->value,
        ])->create();

        Timelog::factory()
            ->count(2)
            ->sequence(
                [
                    'employee_id' => $employee,
                    'minutes' => 60,
                    'started_at' => now()->subMonth(), // 2022-01-10 00:00:00
                    'stopped_at' => now()->subMonth()->addMinutes(60), // 2022-01-10 01:00:00
                ],
                [
                    'employee_id' => $employee,
                    'minutes' => 60,
                    'started_at' => now(),  // 2022-02-10 00:00:00
                    'stopped_at' => now()->addMinutes(60),  // 2022-02-10 01:00:00
                ],
            )
            ->create();

        postJson(route('payday.store'))
            ->assertNoContent();

        assertDatabaseHas('paychecks', [
            'employee_id' => $employee->id,
            'net_amount' => 10 * 100,
        ]);
    });
});

it('should not create paychecks for hourly rate employees without time logs', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    travelTo(Carbon::parse('2022-02-10'), function () {
        Employee::factory([
            'hourly_rate' => 10 * 100,
            'payment_type' => PaymentTypes::HOURLY_RATE->value,
        ])->create();

        postJson(route('payday.store'))
            ->assertNoContent();

        assertDatabaseCount('paychecks', 0);
    });
});
