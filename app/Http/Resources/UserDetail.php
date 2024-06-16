<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class UserDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uid'=>$this->id,
            'user_name'=>$this->name,
            'profile'=>$this->image ? asset('/upload/profiles/'.'user-'.$this->id.'/'.$this->image):"No profile image",
            'email'=>$this->email
        ];
    }
}
