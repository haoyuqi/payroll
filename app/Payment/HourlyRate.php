<?php

namespace App\Payment;

use App\Enums\PaymentTypes;
use App\Models\TimeLog;

class HourlyRate extends PaymentType
{
    public function monthlyAmount(): int
    {
        $hoursWorked = TimeLog::query()
            ->whereBetween('stopped_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->sum('minutes') / 60;

        // 月薪 = 四舍五入(时长) * 时薪
        return round($hoursWorked) * $this->employee->hourly_rate;
    }

    public function type(): string
    {
        return PaymentTypes::HOURLY_RATE->value;
    }

    public function amount(): int
    {
        return $this->employee->hourly_rate;
    }
}
