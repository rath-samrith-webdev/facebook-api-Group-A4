<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FriendList extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'friend_id',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'friend_id','id');
    }
}
