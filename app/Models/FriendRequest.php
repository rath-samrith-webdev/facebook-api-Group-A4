<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FriendRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_from',
        'request_to',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'request_from','id');
    }
}
