<?php

namespace ArtistNinja\Http\Controllers;

use ArtistNinja\Models\PhotographyPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        return view('artist-ninja::admin.packages.index', [
            'packages' => PhotographyPackage::query()->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('artist-ninja::admin.packages.form', [
            'package' => new PhotographyPackage(['currency' => 'USD', 'active' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PhotographyPackage::query()->create($this->validated($request));

        return redirect()->route('artist-ninja.admin.packages.index')
            ->with('success', 'Package created.');
    }

    public function edit(PhotographyPackage $package): View
    {
        return view('artist-ninja::admin.packages.form', ['package' => $package]);
    }

    public function update(Request $request, PhotographyPackage $package): RedirectResponse
    {
        $package->update($this->validated($request));

        return redirect()->route('artist-ninja.admin.packages.index')
            ->with('success', 'Package updated.');
    }

    public function destroy(PhotographyPackage $package): RedirectResponse
    {
        if ($package->bookings()->exists()) {
            $package->update(['active' => false]);

            return redirect()->route('artist-ninja.admin.packages.index')
                ->with('success', 'Package archived because it has bookings.');
        }

        $package->delete();

        return redirect()->route('artist-ninja.admin.packages.index')
            ->with('success', 'Package deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'currency' => ['required', 'string', 'size:3'],
            'active' => ['sometimes', 'boolean'],
        ]) + ['active' => $request->boolean('active')];
    }
}
