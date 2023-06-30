<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Photo;

class Detail extends Model
{
    use HasFactory;

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function photos() {
        return $this->hasMany(Photo::class);
    }
}
