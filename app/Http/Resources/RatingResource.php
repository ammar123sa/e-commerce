<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
        'user' => new UserResource($this->user),
        'product_id' => $this->product_id,
        'rating' => $this->rating,
        'created_at' => $this->created_at,
    ];
    }
}
