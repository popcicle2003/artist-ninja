<?php

namespace ArtistNinja\Models;

use Illuminate\Database\Eloquent\Model;

class PhotographyDelivery extends Model
{
    protected $table = 'artist_ninja_deliveries';

    protected $fillable = [
        'booking_id', 'title', 'type', 'url', 'proofing', 'visible_at',
    ];

    protected $casts = ['proofing' => 'boolean', 'visible_at' => 'datetime'];
}
