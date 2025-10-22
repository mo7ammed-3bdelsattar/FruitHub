<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'itemId' => $this->item_id,
            'productId' => $this->id,
            'productTitle' => $this->title,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'image' => FileHelper::get_file_path($this->image,''),
            'createdAt' => $this->created_at->toISOString(),
            'updatedAt' => $this->updated_at->toISOString(),
        ];
    }
}
