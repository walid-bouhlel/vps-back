<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OS extends Model
{
    use HasFactory;
    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }
}
