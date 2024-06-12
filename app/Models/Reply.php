<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'comment_id',
        'user_id'
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments():BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
