<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $ends = Carbon::parse($this->ends_at);
        $now = Carbon::now();

        // لو العرض منتهي، رجع null (ما بيظهر)
        if ($ends->isPast()) {
            return [];
        }

        $diff = $now->diff($ends);

        return [
            'id' => $this->id,
            'new_price' => $this->new_price,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'time_left' => "{$diff->d}d {$diff->h}h {$diff->i}m",
            'product' => new ProductResource($this->whenLoaded('product')),
            'images' => ProductImageResource::collection($this->product->images),
        ];
    }
}
