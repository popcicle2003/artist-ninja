<?php

namespace ArtistNinja\Http\Controllers;

use ArtistNinja\Models\PhotographyBooking;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function show(int $booking): View
    {
        $record = PhotographyBooking::query()
            ->with(['package', 'deliveries'])
            ->findOrFail($booking);

        return view('artist-ninja::portal', ['booking' => $record]);
    }
}
