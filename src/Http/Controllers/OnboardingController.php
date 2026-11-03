<?php

namespace ArtistNinja\Http\Controllers;

use ArtistNinja\InvoiceNinjaClient;
use ArtistNinja\Branding;
use ArtistNinja\Models\PhotographyBooking;
use ArtistNinja\Models\PhotographyPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function show(): View
    {
        return view('artist-ninja::onboarding', [
            'packages' => PhotographyPackage::query()->where('active', true)->orderBy('name')->get(),
            'branding' => Branding::public(),
        ]);
    }

    public function store(Request $request, InvoiceNinjaClient $invoiceNinja): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'package_id' => ['required', 'integer', 'exists:artist_ninja_packages,id'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $client = $invoiceNinja->createClient($data);

        PhotographyBooking::query()->create([
            ...$data,
            'invoice_ninja_client_id' => data_get($client, 'data.id') ?? data_get($client, 'id'),
            'status' => 'requested',
        ]);

        return redirect()->route('artist-ninja.onboarding.thanks');
    }

    public function thanks(): View
    {
        return view('artist-ninja::thanks');
    }
}
