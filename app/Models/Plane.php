<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plane extends Model
{
    /** @use HasFactory<\Database\Factories\PlaneFactory> */
    use HasFactory;

    protected $fillable = [
        'model',
        'capacity',
    ];

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }
}
