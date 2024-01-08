<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flavor extends Model
{
    use HasFactory;
    protected $fillable = [
        'stackId',
        'name',
        'nameInStack',
        'disk',
        'ram',
        'swap',
        'vcpus',
    ];


    
    /**
     * Get a flavor by ID.
     *
     * @param int $flavorId
     * @return \App\Models\Flavor|null
     */
    public static function getFlavor(int $flavorId)
    {
        return self::find($flavorId);
    }

    /**
     * Get all flavors.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllFlavors()
    {
        return self::all();
    }

    /**
     * Delete a flavor by ID.
     *
     * @param int $flavorId
     * @return bool|null
     */
    public static function deleteFlavor(int $flavorId)
    {
        $flavor = self::find($flavorId);

        if ($flavor) {
            return $flavor->delete();
        }

        return null;
    }
}
