<?php

namespace App\Payment;

use App\Enums\PaymentTypes;

class Salary extends PaymentType
{
    public function monthlyAmount(): int
    {
        return 0;
    }

    public function type(): string
    {
        return PaymentTypes::SALARY->value;
    }

    public function amount(): int
    {
        return $this->employee->salary;
    }
}
