<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable=[
        'post_id',
        'image_name'
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
