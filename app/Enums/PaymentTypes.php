<?php
namespace App\Enums;

enum PaymentTypes: string
{
    case SALARY = 'salary';
    case HOURLY_RATE = 'hourlyRate';

    public function makePaymentType(\App\Models\Employee $employee): \App\Payment\PaymentType
    {
        return match ($this) {
            self::SALARY => new \App\Payment\Salary($employee),
            self::HOURLY_RATE => new \App\Payment\HourlyRate($employee),
        };
    }
}
