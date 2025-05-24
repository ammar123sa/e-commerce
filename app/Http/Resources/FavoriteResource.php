<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'type'        => $this->type,
            'name'        => $this->name,
            'price'       => $this->price,
            'description' => $this->description,
            'attributes'  => $this->attributes,
            'images'      => ProductImageResource::collection($this->whenLoaded('images')),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}

