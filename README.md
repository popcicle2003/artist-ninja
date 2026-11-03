# artist-ninja
Photography client workflow module and Invoice Ninja integration for onboarding, bookings, quotes, and delivery links.

Artist Ninja is a standalone Laravel package for self-hosted Invoice Ninja. Version 1 provides the foundation for:

- Public photography onboarding and package selection.
- Booking records linked to Invoice Ninja client IDs.
- An Invoice Ninja API client for creating clients and quotes.
- A portal-facing booking page with appointment status.
- External delivery and Pixpa proofing links.

Large media files are intentionally not stored in Invoice Ninja or Artist Ninja. Store media with Pixpa, object storage, or a dedicated delivery provider, then publish protected links through `artist_ninja_deliveries`.

## Installation

Install the package in the self-hosted Invoice Ninja application:

```bash
composer require popcicle2003/artist-ninja
php artisan vendor:publish --tag=artist-ninja-config
php artisan migrate
```

Configure the integration in `.env`:

```dotenv
INVOICE_NINJA_URL=https://invoices.example.com
INVOICE_NINJA_API_TOKEN=
INVOICE_NINJA_COMPANY_KEY=
ARTIST_NINJA_ROUTE_PREFIX=artist-ninja
```

The initial routes are:

- `GET /artist-ninja/onboarding`
- `POST /artist-ninja/onboarding`
- `GET /artist-ninja/portal/{booking}`

The portal route is deliberately a small integration surface in v1. The next integration step is to register it inside Invoice Ninja's authenticated contact portal and replace the numeric booking URL with a signed, contact-scoped route.

## Current boundaries

Scheduling provider callbacks, Invoice Ninja quote line-item mapping, email delivery, contact-portal authentication, rescheduling rules, and native proofing comments are planned integration work. The package keeps those boundaries explicit so it can support Pixpa without storing or proxying media.
