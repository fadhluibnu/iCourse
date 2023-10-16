<?php

namespace App\Http\Resources;

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
        return [
            'author' => $this->user,
            'title' => $this->title,
            'meta_desc' => $this->meta_desc,
            'slug' => $this->slug,
            'tag' => $this->tag,
            'category' => $this->category,
            'body' => $this->body
        ];
    }
}
