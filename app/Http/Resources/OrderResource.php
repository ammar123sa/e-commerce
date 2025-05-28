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
            'id' => $this->id,
            'quantity' => $this->quantity,
            'total_amount' => number_format($this->total_amount, 2),
            'is_paid' => $this->is_paid,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
