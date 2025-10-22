<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'city' =>[
                'name' => $this->city->name,
                'shipping_cost' => $this->city->shipping_cost,
            ],
            'floor' => $this->floor,
            'building' => $this->building,
            'apartment' => $this->apartment,
        ];
    }
}
