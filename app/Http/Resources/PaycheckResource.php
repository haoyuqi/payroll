<?php

namespace App\Http\Resources;

use App\VOs\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class PaycheckResource extends JsonApiResource
{

    public function toAttributes($request):array
    {
        return [
            'amount' => [
                    'cents' => Money::from($this->employee->payment_type->amount())->toCents(),
                    'dollars' => Money::from($this->employee->payment_type->amount())->toDollars(),
                ],
            'payed_at' => now(),
        ];
    }

    public function toId(Request $request):string
    {
        return $this->uuid;
    }

    public function toRelationships($request): array
    {
        return [
            'employee' => fn() => EmployeeResource::make($this->employee)
        ];
    }
}
