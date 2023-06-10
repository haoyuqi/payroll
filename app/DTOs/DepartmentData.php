<?php

namespace App\DTOs;

class DepartmentData
{
    public function __construct(
        public string $name,
        public ?string $description
    ) {
    }
}
