<?php

namespace App\Http\Resources\Collage;

use App\Http\Resources\Rating\RatingsResource;
use App\Http\Resources\Rating\ShowRatingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCollageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'founded_at' => $this->founded_at,
            'average_rating' => RatingsResource::collection($this->whenLoaded('ratings'))->avg('rating'),
            'rating_count' => RatingsResource::collection($this->whenLoaded('ratings'))->count(),
            'ratings' => ShowRatingResource::collection($this->whenLoaded('ratings'))
        ];
    }
}
