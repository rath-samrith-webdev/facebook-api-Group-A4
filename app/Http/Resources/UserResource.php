<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'=>$this->name,
            'profile'=>$this->image ? asset('/upload/profiles/'.'user-'.$this->id.'/'.$this->image):"No profile image",
            'friends_count'=>$this->friendlists()->get()->count(),
            'friends'=>FriendListResource::collection($this->friendlists()->get()),
            'friend_requests'=>FriendRequestResource::collection($this->friendrequests()->get())
        ];
    }
}
