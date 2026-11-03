<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artist Ninja packages</title>
    <style>
        :root { font-family: ui-sans-serif, system-ui, sans-serif; color: #172033; background: #f5f7fb; }
        body { margin: 0; padding: 32px 16px; }
        main { max-width: 1000px; margin: auto; }
        .top { align-items: center; display: flex; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
        h1 { margin: 0; }
        a, button { border: 0; border-radius: 6px; cursor: pointer; font: inherit; font-weight: 700; padding: 10px 14px; text-decoration: none; }
        .button { background: #1c64f2; color: #fff; }
        .card { background: #fff; border: 1px solid #e3e8f0; border-radius: 8px; overflow: hidden; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-bottom: 1px solid #e9edf3; padding: 16px; text-align: left; vertical-align: middle; }
        th { color: #68748a; font-size: .8rem; text-transform: uppercase; }
        .muted { color: #68748a; }
        .actions { display: flex; align-items: center; gap: 8px; }
        .actions a { color: #1c64f2; padding: 0; }
        .actions button { background: none; color: #b42318; padding: 0; }
        .notice { background: #ecfdf3; color: #027a48; border-radius: 6px; padding: 12px 14px; margin-bottom: 16px; }
        @media (max-width: 700px) { .card { overflow-x: auto; } table { min-width: 680px; } }
    </style>
</head>
<body>
<main>
    <div class="top">
        <div><p class="muted">Artist Ninja</p><h1>Photography packages</h1></div>
        <a class="button" href="{{ route('artist-ninja.admin.packages.create') }}">Add package</a>
    </div>
    @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
    <div class="card">
        <table>
            <thead><tr><th>Name</th><th>Description</th><th>Price</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($packages as $package)
                <tr>
                    <td><strong>{{ $package->name }}</strong></td>
                    <td class="muted">{{ $package->description ?: '—' }}</td>
                    <td>{{ $package->currency }} {{ number_format((float) $package->price, 2) }}</td>
                    <td>{{ $package->active ? 'Active' : 'Archived' }}</td>
                    <td class="actions">
                        <a href="{{ route('artist-ninja.admin.packages.edit', $package) }}">Edit</a>
                        <form method="post" action="{{ route('artist-ninja.admin.packages.destroy', $package) }}">
                            @csrf @method('DELETE')
                            <button type="submit">{{ $package->active ? 'Archive' : 'Delete' }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No packages yet. Add your first package.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
