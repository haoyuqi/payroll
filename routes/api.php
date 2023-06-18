<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentEmployeeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaydayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('departments', DepartmentController::class);
Route::apiResource('employees', EmployeeController::class);

Route::get(
    'departments/{department}/employees',
    [DepartmentEmployeeController::class, 'index']
)->name('department.employees.index');

Route::post(
    'paycheck',
    [PaydayController::class, 'store']
)->name('payday.store');
