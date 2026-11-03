<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Photography onboarding</title>
    <style>
        @font-face { font-family: 'Open Sans'; font-style: normal; font-weight: 400 800; font-display: swap; src: url('{{ $branding['font_url'] }}') format('woff2'); }
        :root { color-scheme: light; font-family: 'Open Sans', ui-sans-serif, system-ui, sans-serif; color: #172033; background: #f5f7fb; --artist-primary: {{ $branding['primary_color'] }}; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 32px 16px; }
        main { width: min(760px, 100%); background: #fff; border: 1px solid #e3e8f0; border-radius: 8px; box-shadow: 0 18px 50px #17203314; padding: clamp(24px, 5vw, 52px); }
        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
        .brand img { max-width: 180px; max-height: 48px; object-fit: contain; }
        .eyebrow { color: #68748a; font-size: .78rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        h1 { margin: 8px 0 10px; font-size: clamp(2rem, 5vw, 3.2rem); line-height: 1.05; }
        .intro { color: #68748a; margin: 0 0 32px; }
        .availability { background: #f5f7fb; border: 1px solid #e3e8f0; border-radius: 8px; margin-bottom: 24px; padding: 16px; }
        .availability a { color: var(--artist-primary); font-weight: 700; }
        form { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
        label { display: grid; gap: 8px; color: #344054; font-size: .9rem; font-weight: 650; }
        input, select, textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; background: #fff; color: #172033; font: inherit; padding: 12px 13px; }
        input:focus, select:focus, textarea:focus { outline: 3px solid color-mix(in srgb, var(--artist-primary) 25%, transparent); border-color: var(--artist-primary); }
        textarea { min-height: 110px; resize: vertical; }
        .full { grid-column: 1 / -1; }
        button { grid-column: 1 / -1; border: 0; border-radius: 6px; background: var(--artist-primary); color: #fff; cursor: pointer; font: inherit; font-weight: 700; padding: 14px 18px; }
        button:hover { filter: brightness(90%); }
        .errors { border-radius: 10px; background: #fff1f1; color: #a32929; padding: 14px 18px; margin-bottom: 20px; }
        @media (max-width: 640px) { form { grid-template-columns: 1fr; } .full { grid-column: auto; } }
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
        <h1>Plan your photography session</h1>
        <p class="intro">Tell us a little about your session and choose the package that fits best.</p>
        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @if ($booking_url)
            <div class="availability">
                <strong>Check availability</strong>
                <div class="intro" style="margin: 6px 0 0">Choose an available date in the booking calendar, then enter it below.</div>
                <a href="{{ $booking_url }}" target="_blank" rel="noopener">Open booking calendar →</a>
            </div>
        @endif
        <form method="post" action="{{ route('artist-ninja.onboarding.store') }}">
            @csrf
            <label>Name <input name="name" required value="{{ old('name') }}"></label>
            <label>Email <input type="email" name="email" required value="{{ old('email') }}"></label>
            <label>Phone <input name="phone" value="{{ old('phone') }}"></label>
            <label>Package
                <select name="package_id" required>
                    <option value="">Choose a package</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}" @selected(old('package_id') == $package->id)>
                            {{ $package->name }} - {{ $package->currency }} {{ $package->price }}
                        </option>
                    @endforeach
                </select>
            </label>
            <label>Preferred start <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}"></label>
            <label>Preferred end <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}"></label>
            <label class="full">Notes <textarea name="notes">{{ old('notes') }}</textarea></label>
            <button type="submit">Request my session</button>
        </form>
    </main>
</body>
</html>
