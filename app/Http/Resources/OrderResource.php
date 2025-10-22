<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "addressId" => $this->address_id,
            "status" => $this->status,
            "financials" => [
                "shippingCost" => $this->address->city->shipping_cost,
                "subtotalPrice" => $this->subtotal_price,
                "totalPrice" => $this->total_price,
            ],
            'createdAt' => $this->created_at->toISOString(),
            'updatedAt' => $this->updated_at->toISOString(),
        ];
    }
}
