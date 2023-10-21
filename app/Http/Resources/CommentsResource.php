<?php

namespace App\Http\Resources;

use App\Handler\HandlerEverything;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
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
            'name' => $this->name,
            'post' => [
                'title' => $this->post->title,
                'slug' => $this->post->slug,
            ],
            'body' => $this->body,
            'created_at' => $handler->dateFormat($this->created_at),
            'updated_at' => $handler->dateFormat($this->updated_at),
        ];
    }
}
