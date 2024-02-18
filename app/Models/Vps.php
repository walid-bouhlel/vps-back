<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','server_name','instance_id','ipv4','flavor_id','image_id','description','instance','os_id','config_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
