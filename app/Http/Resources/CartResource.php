<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

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
            'id' => $this->id,
            'product' => (new ProductResource($this->product)),
            'quantity' => $this->quantity,
            'created_at' => tanggal_dan_waktu($this->created_at),
            'updated_at' => tanggal_dan_waktu($this->updated_at),
        ];
    }
}
