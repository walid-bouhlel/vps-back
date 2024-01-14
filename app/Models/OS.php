<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OS extends Model
{
    protected $table = 'os';
    use HasFactory;
    protected $fillable = [
        'idInStack',
        'name',
        'nameInStack',
        'distribution_id',
        'version',
    ];
    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }

    
    public static function deleteOS(int $OSId)
    {
        $OS = self::find($OSId);

        if ($OS) {
            return $OS->delete();
        }

        return null;
    }
    public static function getAllOSs()
    {
        return self::all();
    }
    
}
