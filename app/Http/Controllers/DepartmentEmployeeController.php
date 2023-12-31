<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class DepartmentEmployeeController extends Controller
{
    public function index(Request $request, Department $department)
    {
        $employees = QueryBuilder::for(Employee::class)
            ->allowedFilters(['full_name', 'job_title', 'email'])
            ->whereBelongsTo($department)
            ->get();

        return EmployeeResource::collection($employees);
    }
}
