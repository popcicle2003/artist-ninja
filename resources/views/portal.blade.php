<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>Your photography session</title></head>
<body>
    <main>
        <h1>{{ $booking->package->name }}</h1>
        <p>Status: {{ ucfirst($booking->status) }}</p>
        @if ($booking->starts_at)
            <p>Appointment: {{ $booking->starts_at->toDayDateTimeString() }}</p>
        @endif
        <h2>Deliveries</h2>
        @forelse ($booking->deliveries->where('visible_at', '<=', now()) as $delivery)
            <p><a href="{{ $delivery->url }}">{{ $delivery->title }}</a> ({{ $delivery->type }})</p>
        @empty
            <p>Delivery links and proofing galleries will appear here when published.</p>
        @endforelse
    </main>
</body>
</html>
