<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;


    protected $fillable = ['name','logopath'];

    public function operatingSystems()
    {
        return $this->hasMany(OS::class);
    }
    
}
