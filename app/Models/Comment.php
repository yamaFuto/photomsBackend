<?php

namespace App\Models;

use App\Models\Detial;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    public function detail() {
        return $this->belongsTo(Detail::class);
    }
}
