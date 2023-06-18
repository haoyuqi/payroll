<?php

use App\Enums\PaymentTypes;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('should return all employees for a department', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $department = Department::factory(['name' => 'Development'])->create();
    $marketing = Department::factory(['name' => 'Marketing'])->create();

    $developers = Employee::factory([
        'department_id' => $department->id,
        'payment_type' => PaymentTypes::from('salary')->value,
    ])->count(2)->create();

    $employees = getJson(route('department.employees.index', ['department' => $department]))->json('data');

    expect($employees)->toHaveCount(2);
    expect($employees)->each(fn ($employees) => $employees->id->toBeIn($developers->pluck('uuid')));
});

it('should filter employees', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $development = Department::factory(['name' => 'Development'])->create();
    $marketing = Department::factory(['name' => 'Marketing'])->create();

    Employee::factory([
        'department_id' => $development->id,
        'payment_type' => PaymentTypes::from('salary')->value,
    ])->count(4)->create();

    $developer = Employee::factory([
        'full_name' => 'Test John Doe',
        'department_id' => $development->id,
        'payment_type' => PaymentTypes::from('salary')->value,
    ])->create();

    Employee::factory([
        'department_id' => $marketing->id,
        'payment_type' => PaymentTypes::from('hourlyRate')->value,
    ])->count(2)->create();

    $employees = getJson(
        route('department.employees.index', [
            'department' => $development,
            'filter' => [
                'full_name' => 'Test',
            ],
        ])
    )->json('data');

    expect($employees)->toHaveCount(1);
    expect($employees[0])->id->toBe($developer->uuid);
});
