<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailResource;

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
            'id' => $this->id,
            'order_code' => $this->order_code,
            'total_price' => rupiah($this->total_price),
            'total_quantity' => $this->total_quantity,
            'order_detail' => (new OrderDetailResource($this->order_details)),
            'created_at' => tanggal_dan_waktu($this->created_at),
            'updated_at' => tanggal_dan_waktu($this->updated_at),
        ];
    }
}
