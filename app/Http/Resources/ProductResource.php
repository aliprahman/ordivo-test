<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => rupiah($this->price),
            'stock' => $this->stock,
            'created_at' => tanggal_dan_waktu($this->created_at),
            'updated_at' => tanggal_dan_waktu($this->updated_at),
        ];
    }
}
