<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'description' => $this->description,
            'created_at' => $this->created_at->diffForHumans(),
            'category_id' => isset($this->category_id) ? $this->category_id : 0,
            'user' => new UserResource($this->user)
        ];
    }
}
