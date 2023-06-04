<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class DepartmentResource extends JsonApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toAttributes($request) :array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
