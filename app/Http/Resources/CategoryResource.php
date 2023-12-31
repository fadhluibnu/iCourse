<?php

namespace App\Http\Resources;

use App\Handler\HandlerEverything;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $handler = new HandlerEverything();
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'posts' => PostCollection::collection($this->posts),
            'created_at' => $handler->dateFormat($this->created_at),
            'updated_at' => $handler->dateFormat($this->updated_at),
        ];
    }
}
