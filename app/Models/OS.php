<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OS extends Model
{
    use HasFactory;
    protected $fillable = [
        'idInStack',
        'name',
        'nameInStack',
        'distrubution_id',
        'version',
    ];
    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }
    
}
