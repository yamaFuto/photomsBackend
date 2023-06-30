<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Detail;

class Photo extends Model
{
    use HasFactory;

    public function detail() {
        return $this->belongsTo(Detail::class);
    }
}
