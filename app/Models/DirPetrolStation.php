<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DirPetrolStation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Получить данные о заправках на АЗС.
     */
    public function listRefilling()
    {
        return $this->hasMany(Refilling::class, 'petrol_stations_id', 'id');
    }
}
