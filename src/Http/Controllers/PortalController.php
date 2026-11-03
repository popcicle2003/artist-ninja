<?php

namespace ArtistNinja\Http\Controllers;

use ArtistNinja\Models\PhotographyBooking;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function currentClient(): View
    {
        $contact = auth()->guard('contact')->user();

        $booking = PhotographyBooking::query()
            ->with(['package', 'deliveries'])
            ->where('invoice_ninja_client_id', (string) $contact->client_id)
            ->latest()
            ->first();

        return view('artist-ninja::portal', ['booking' => $booking]);
    }

}
