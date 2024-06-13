<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class React extends Model
{
    use HasFactory;
    public function like():HasOne
    {
        return $this->hasOne(Like::class);
    }
}
