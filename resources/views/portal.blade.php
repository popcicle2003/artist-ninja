<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your photography session</title>
    <style>
        :root { font-family: Inter, ui-sans-serif, system-ui, sans-serif; color: #172033; background: #f5f7fb; }
        body { margin: 0; padding: 32px 16px; }
        main { max-width: 860px; margin: auto; }
        .eyebrow { color: #68748a; font-size: .78rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        h1 { margin: 8px 0 28px; font-size: clamp(2rem, 5vw, 3rem); }
        .card { background: #fff; border: 1px solid #e3e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 12px 35px #1720330d; margin-bottom: 18px; }
        .status { display: inline-block; border-radius: 999px; background: #e8efff; color: #3156b5; font-size: .85rem; font-weight: 700; padding: 6px 11px; }
        .muted { color: #68748a; }
        a { color: #3156b5; font-weight: 650; }
        .empty { color: #68748a; }
    </style>
</head>
<body>
    <main>
        <div class="eyebrow">Artist Ninja</div>
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
                    <p><strong>Appointment</strong><br><span class="muted">{{ $booking->starts_at->toDayDateTimeString() }}</span></p>
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
