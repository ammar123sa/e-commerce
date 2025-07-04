<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'product_id' => $this->product_id,
            'comment' => $this->comment,
            'created_at' => [
                'raw' => $this->created_at,
                'human' => $this->created_at->diffForHumans(),
            ],
        ];
    }
}
