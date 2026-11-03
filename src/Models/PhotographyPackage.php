<?php

namespace ArtistNinja\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotographyPackage extends Model
{
    protected $table = 'artist_ninja_packages';

    protected $fillable = ['name', 'description', 'price', 'currency', 'active'];

    protected $casts = ['price' => 'decimal:2', 'active' => 'boolean'];

    public function bookings(): HasMany
    {
        return $this->hasMany(PhotographyBooking::class, 'package_id');
    }
}
