<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_liker',
        'post_id',
        'created_at',
        'updated_at'
    ];
}
