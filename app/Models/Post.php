<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $table = 'post';
    public $fillable = [
        'user_id', 'description', 'image', 'can_comment'
    ];

    public function likes () {
        return $this->hasMany(Like::class, 'post_id');
    }

}