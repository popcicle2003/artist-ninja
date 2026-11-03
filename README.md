# artist-ninja
Photography client workflow module and Invoice Ninja integration for onboarding, bookings, quotes, and delivery links.

Artist Ninja is a standalone Laravel package for self-hosted Invoice Ninja. Version 1 provides the foundation for:

- Public photography onboarding and package selection.
- Booking records linked to Invoice Ninja client IDs.
- An Invoice Ninja API client for creating clients and quotes.
- A portal-facing booking page with appointment status.
- External delivery and Pixpa proofing links.
- Invoice Ninja company branding on onboarding and portal pages.

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
- `GET /client/artist-ninja/`
- `GET /artist-ninja/admin/packages`

The client route uses Invoice Ninja's `contact` guard and only loads the latest booking whose `invoice_ninja_client_id` matches the logged-in contact's client. It is safe to link from the authenticated portal at:

```text
https://your-invoice-ninja-domain.example/client/artist-ninja/
```

The package cannot add a navigation item to Invoice Ninja's core Blade layout without modifying the host application. To expose it in the portal menu, add a link to the host's client navigation component:

```blade
<a href="{{ route('client.artist-ninja.portal') }}">Photography</a>
```

The onboarding and portal pages inherit the active company's logo, primary color, Open Sans font, and self-hosted portal custom CSS. After updating the package in the Invoice Ninja container, run `php artisan optimize:clear`.

## Packages and scheduling

After installation, sign in to the normal Invoice Ninja admin account and open `/artist-ninja/admin/packages`. Create, edit, archive, and delete packages there. Packages with existing bookings are archived instead of deleted.

Some newer Invoice Ninja installations authenticate the admin SPA through API state rather than a Laravel session. For those installations, configure a separate Artist Ninja admin key in the container:

```dotenv
ARTIST_NINJA_ADMIN_KEY=generate-a-long-random-secret
```

Then open the package manager once with:

```text
/artist-ninja/admin/packages?key=generate-a-long-random-secret
```

The key creates a session flag for your browser so you can navigate the package manager without repeating it. Prefer a long random value, use HTTPS, and do not share the URL publicly. Clear the session by logging out or clearing the site cookies.

For Google Appointment Schedules, add the public booking page URL to the container environment:

```dotenv
ARTIST_NINJA_BOOKING_URL=https://calendar.google.com/calendar/appointments/...
```

Artist Ninja displays a link to that calendar during onboarding. Google remains the source of truth for availability and booking; the submitted preferred start/end time is stored with the Artist Ninja booking request.

## Current boundaries

Scheduling provider callbacks, Invoice Ninja quote line-item mapping, email delivery, contact-portal authentication, rescheduling rules, and native proofing comments are planned integration work. The package keeps those boundaries explicit so it can support Pixpa without storing or proxying media.
