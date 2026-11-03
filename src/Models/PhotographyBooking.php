<?php

namespace ArtistNinja\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotographyBooking extends Model
{
    protected $table = 'artist_ninja_bookings';

    protected $fillable = [
        'name', 'email', 'phone', 'invoice_ninja_client_id', 'package_id',
        'starts_at', 'ends_at', 'status', 'notes', 'quote_id',
    ];

    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime'];

    public function package(): BelongsTo
    {
        return $this->belongsTo(PhotographyPackage::class, 'package_id');
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(PhotographyDelivery::class, 'booking_id');
    }
}
