<?php

use App\Models\Department;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\putJson;

it('should update a department', function (string $name, string $description) {
    Sanctum::actingAs(User::factory()->create(), ['*']);

    $department = Department::factory()->create([
        'name' => 'Development',
    ]);

    putJson(route('departments.update', compact('department')), [
        'name' => $name,
        'description' => $description,
    ])->assertNoContent();

    expect(Department::find($department->id))
        ->name->toBe($name)
        ->description->toBe($description);
})->with([
    ['name' => 'Development', 'description' => 'Update description'],
    ['name' => 'Development New', 'description' => 'Update description'],
]);
