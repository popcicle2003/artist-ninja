<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $package->exists ? 'Edit' : 'Add' }} package</title>
    <style>
        :root { font-family: ui-sans-serif, system-ui, sans-serif; color: #172033; background: #f5f7fb; }
        body { margin: 0; padding: 32px 16px; }
        main { max-width: 700px; margin: auto; background: #fff; border: 1px solid #e3e8f0; border-radius: 8px; padding: 32px; }
        h1 { margin-top: 0; } form { display: grid; gap: 18px; } label { display: grid; gap: 8px; font-weight: 650; }
        input, textarea { border: 1px solid #cbd5e1; border-radius: 6px; font: inherit; padding: 12px; } textarea { min-height: 120px; resize: vertical; }
        .check { display: flex; align-items: center; gap: 8px; } .check input { width: auto; }
        .buttons { display: flex; gap: 12px; align-items: center; } a { color: #1c64f2; } button { background: #1c64f2; border: 0; border-radius: 6px; color: #fff; cursor: pointer; font: inherit; font-weight: 700; padding: 12px 16px; }
        .errors { background: #fff1f1; color: #a32929; border-radius: 6px; padding: 12px 14px; }
    </style>
</head>
<body>
<main>
    <p><a href="{{ route('artist-ninja.admin.packages.index') }}">← Packages</a></p>
    <h1>{{ $package->exists ? 'Edit package' : 'Add package' }}</h1>
    @if ($errors->any()) <div class="errors">@foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <form method="post" action="{{ $package->exists ? route('artist-ninja.admin.packages.update', $package) : route('artist-ninja.admin.packages.store') }}">
        @csrf
        @if ($package->exists) @method('PUT') @endif
        <label>Name <input name="name" required value="{{ old('name', $package->name) }}"></label>
        <label>Description <textarea name="description">{{ old('description', $package->description) }}</textarea></label>
        <label>Price <input type="number" step="0.01" min="0" name="price" required value="{{ old('price', $package->price) }}"></label>
        <label>Currency <input name="currency" maxlength="3" required value="{{ old('currency', $package->currency) }}"></label>
        <label class="check"><input type="checkbox" name="active" value="1" @checked(old('active', $package->active))> Show this package on onboarding</label>
        <div class="buttons"><button type="submit">Save package</button><a href="{{ route('artist-ninja.admin.packages.index') }}">Cancel</a></div>
    </form>
</main>
</body>
</html>
