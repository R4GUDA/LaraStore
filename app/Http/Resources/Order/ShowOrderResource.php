<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\PositionsListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOrderResource extends JsonResource
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
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'delivery_date' => $this->delivery_date,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'positions' => PositionsListResource::collection($this->products)
        ];;
    }
}
