<?php

namespace App\Http\Resources;

use App\VOs\Money;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class EmployeeResource extends JsonApiResource
{
    public function toAttributes($request): array
    {
        return [
            'name' => $this->full_name,
            'jobTitle' => $this->job_title,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'payment' => [
                'type' => $this->payment_type->type(),
                'amount' => [
                    'cents' => Money::from($this->payment_type->amount())->toCents(),
                    'dollars' => Money::from($this->payment_type->amount())->toDollars(),
                ],
            ],
        ];
    }

    public function toId(Request $request): string
    {
        return $this->uuid;
    }
}
