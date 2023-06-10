<?php

namespace App\DTOs;

use App\Http\Requests\UpsertEmployeeRequest;
use App\Models\Department;

class EmployeeData
{
    public function __construct(
        public string $fullName,
        public string $email,
        public Department $department,
        public string $jobTitle,
        public string $paymentType,
        public ?int $salary,
        public ?int $hourlyRate,
    ) {
    }

    public static function formData(UpsertEmployeeRequest $request): self
    {
        return new static(
            $request->fullName,
            $request->email,
            $request->getDepartment(),
            $request->jobTitle,
            $request->paymentType,
            $request->salary,
            $request->hourlyRate,
        );
    }
}
