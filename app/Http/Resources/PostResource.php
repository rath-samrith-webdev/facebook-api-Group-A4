<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'context'=>$this->text,
            'image'=>ImageResource::collection($this->images()->get()),
            'post_by'=>UserDetail::make($this->user),
            'likes_count'=>$this->likes()->get()->count(),
            'likes'=>LikeResource::collection($this->likes()->get()),
            'comments'=>$this->comments()->get()
        ];
    }
}
