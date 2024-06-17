<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'context' => $this->text,
            'user' => UserDetail::make($this->user),
            'replies' => ReplyResource::collection($this->replies()->get())
        ];
    }
}
