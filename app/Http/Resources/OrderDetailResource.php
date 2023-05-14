<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'price' => rupiah($this->price),
            'quantity' => $this->quantity,
            'product' => (new ProductResource($this->product)),
            'created_at' => tanggal_dan_waktu($this->created_at),
            'updated_at' => tanggal_dan_waktu($this->updated_at),
        ];
    }
}
