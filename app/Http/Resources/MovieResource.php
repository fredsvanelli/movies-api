<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'categories' => $this->whenLoaded('categories'),
                'actors' => $this->whenLoaded('actors'),
            ]
        );
    }
}
