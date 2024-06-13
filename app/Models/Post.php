<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'user_id',
        'image_id',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments():HasMany{
        return $this->hasMany(Comment::class);
    }



}
