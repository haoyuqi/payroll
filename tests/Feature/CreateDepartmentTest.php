<?php

use App\Models\Department;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\postJson;

it('should create a department', function () {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $department = postJson(route('departments.store'), [
        'name' => 'Development',
        'description' => 'Awesome developers across the board!',
    ])->json('data');

    expect($department)
        ->attributes->name->toBe('Development')
        ->attributes->description->toBe('Awesome developers across the board!');
});

it('should return 422 if name is invalid', function (?string $name) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    Department::factory([
        'name' => 'Development',
    ])->create();

    postJson(route('departments.store'), [
        'name' => $name,
        'description' => 'description',
    ])->assertInvalid(['name']);
})->with([
    '',
    null,
    'Development',
]);
