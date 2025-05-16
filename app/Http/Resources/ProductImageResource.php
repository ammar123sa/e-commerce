<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'image_url' => $this->image_url,
            'product_id'=> $this->product_id,
            'created_at'=> $this->created_at,
        ];
    }
}

