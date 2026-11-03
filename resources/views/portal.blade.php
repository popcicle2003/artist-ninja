<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your photography session</title>
    <style>
        @font-face { font-family: 'Open Sans'; font-style: normal; font-weight: 400 800; font-display: swap; src: url('{{ $branding['font_url'] }}') format('woff2'); }
        :root { font-family: 'Open Sans', ui-sans-serif, system-ui, sans-serif; color: #172033; background: #f5f7fb; --artist-primary: {{ $branding['primary_color'] }}; }
        body { margin: 0; padding: 32px 16px; }
        main { max-width: 860px; margin: auto; }
        .eyebrow { color: #68748a; font-size: .78rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        h1 { margin: 8px 0 28px; font-size: clamp(2rem, 5vw, 3rem); }
        .brand { margin-bottom: 24px; } .brand img { max-width: 180px; max-height: 48px; object-fit: contain; }
        .card { background: #fff; border: 1px solid #e3e8f0; border-radius: 8px; padding: 24px; box-shadow: 0 12px 35px #1720330d; margin-bottom: 18px; }
        .status { display: inline-block; border-radius: 999px; background: color-mix(in srgb, var(--artist-primary) 12%, white); color: var(--artist-primary); font-size: .85rem; font-weight: 700; padding: 6px 11px; }
        .muted { color: #68748a; }
        a { color: #3156b5; font-weight: 650; }
        .empty { color: #68748a; }
    </style>
    {!! $branding['custom_css'] !!}
</head>
<body>
    <main>
        <div class="brand">
            @if ($branding['logo'])
                <img src="{{ $branding['logo'] }}" alt="{{ $branding['name'] }} logo">
            @else
                <div class="eyebrow">{{ $branding['name'] }}</div>
            @endif
        </div>
        @if (! $booking)
            <section class="card">
                <h1>No photography session yet</h1>
                <p class="empty">When your session is booked, its appointment and delivery links will appear here.</p>
            </section>
        @else
            <h1>{{ $booking->package->name }}</h1>
            <section class="card">
                <span class="status">{{ ucfirst($booking->status) }}</span>
                @if ($booking->starts_at)
                    <p><strong>Appointment</strong><br><span class="muted">{{ $booking->starts_at->format($branding['date_format'] . ' ' . $branding['time_format']) }}</span></p>
                @endif
            </section>
            <section class="card">
                <h2>Deliveries</h2>
                @forelse ($booking->deliveries->filter(fn ($delivery) => $delivery->visible_at === null || $delivery->visible_at->isPast()) as $delivery)
                    <p><a href="{{ $delivery->url }}">{{ $delivery->title }}</a> <span class="muted">({{ $delivery->type }})</span></p>
                @empty
                    <p class="empty">Delivery links and proofing galleries will appear here when published.</p>
                @endforelse
            </section>
        @endif
    </main>
</body>
</html>
