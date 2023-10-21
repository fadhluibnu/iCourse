<?php

namespace App\Http\Resources;

use App\Handler\HandlerEverything;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $handler = new HandlerEverything();
        return [
            'id' => $this->id,
            'author' => [
                "name" => $this->user->name,
                "photo" => $this->user->photo,
                "username" => $this->user->username,
            ],
            'title' => $this->title,
            'meta_desc' => $this->meta_desc,
            'slug' => $this->slug,
            'tag' => $this->tag,
            'category' => [
                'title' => $this->categories->title,
                'slug' => $this->categories->slug,
            ],
            'cover' => $this->cover,
            'body' => $this->body,
            'comments' => CommentsResource::collection($this->comments),
            'created_at' => $handler->dateFormat($this->created_at),
            'updated_at' => $handler->dateFormat($this->updated_at),
        ];
    }
}
