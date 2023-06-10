<?php

namespace App\Http\Resources;

use TiMacDonald\JsonApi\JsonApiResource;

class EmployeeResource extends JsonApiResource
{
    public function toAttributes($request): array
    {
        return [
            'name' => $this->full_name,
            'jobTitle' => $this->job_title,
            'email' => $this->email,
            'payment' => [
                'type' => $this->payment_type->type(),
                'amount' => $this->payment_type->amount(),
            ],
        ];
    }
}
