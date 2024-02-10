<?php

namespace App\Models;

use App\Models\DirPetrolStation;
use MoonShine\Models\MoonshineUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refilling extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id',
    ];

    /**
     * Получить данные о создателе записи о заправке.
     */
    public function owner()
    {
        return $this->belongsTo(MoonshineUser::class, 'owner_id', 'id');
    }

    /**
     * Получить данные о водителе.
     */
    public function driver()
    {
        return $this->belongsTo(MoonshineUser::class, 'driver_id', 'id');
    }

    /**
     * Получить данные о АЗС.
     */
    public function petrolStation()
    {
        return $this->belongsTo(DirPetrolStation::class, 'petrol_stations_id', 'id');
    }
}
