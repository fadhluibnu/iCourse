<?php

namespace App\Http\Resources;

use App\Handler\HandlerEverything;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorialResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'slug' => $this->slug,
            'description' => $this->description,
            'level' => $this->level,
            'posts' => PostCollection::collection($this->post),
            'created_at' => $handler->dateFormat($this->created_at),
            'updated_at' => $handler->dateFormat($this->updated_at),
        ];
    }
}
