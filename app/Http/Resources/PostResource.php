<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an arraosty.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return[
            'id' => $this->id,
            'topic' => $this->topic,
            'body' =>$this->body,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "category" => new CategoryResource($this->category),
            "comments" => CommentResource::collection($this->comments)
        ];
    }
}
