<?php

namespace App\Http\Resources\Rating;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Likes\LikesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowRatingResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'likes' => LikesResource::collection($this->whenLoaded('likes'))?->count(),
        ];
    }
}
