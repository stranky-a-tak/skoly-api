<?php

namespace App\Http\Resources\Rating;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingsResource extends JsonResource
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
            'rating' => $this->rating,
            'body' => $this->body,
            'num_of_comments' => CommentResource::collection($this->whenLoaded('comments'))->count(),
            'user' => new UserResource($this->whenLoaded('user')),
            'comment' => new CommentResource($this->whenLoaded('comments')[0]),
        ];
    }
}
