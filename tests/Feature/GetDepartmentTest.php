<?php

use App\Models\Department;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('should return a department', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $development = Department::factory(['name' => 'Development'])->create();

    $department = getJson(route('departments.show', ['department' => $development]))
        ->json('data');

    expect($department)
        ->attributes->name->toBe('Development');
});

it('should return all departments', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $names = ['Development', 'Market', 'Administration'];
    foreach ($names as $name) {
        Department::factory(['name' => 'Development'])->create();
    }

    $departments = getJson(route('departments.index'))->json();

    expect($departments)->toHaveCount(3);
});
