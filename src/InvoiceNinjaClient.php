<?php

namespace ArtistNinja;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class InvoiceNinjaClient
{
    protected function request(): PendingRequest
    {
        $baseUrl = rtrim((string) config('artist-ninja.invoice_ninja.base_url'), '/');
        $token = (string) config('artist-ninja.invoice_ninja.api_token');

        if ($baseUrl === '' || $token === '') {
            throw new RuntimeException('Artist Ninja Invoice Ninja API credentials are not configured.');
        }

        return Http::baseUrl($baseUrl)
            ->acceptJson()
            ->withToken($token)
            ->timeout(15);
    }

    public function createClient(array $attributes): array
    {
        return $this->request()->post('/api/v1/clients', [
            'name' => $attributes['name'],
            'contacts' => [[
                'first_name' => $attributes['first_name'] ?? null,
                'last_name' => $attributes['last_name'] ?? null,
                'email' => $attributes['email'],
                'phone' => $attributes['phone'] ?? null,
            ]],
        ])->throw()->json();
    }

    public function createQuote(array $attributes): array
    {
        return $this->request()->post('/api/v1/quotes', $attributes)->throw()->json();
    }
}
