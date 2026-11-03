<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Photography onboarding</title></head>
<body>
    <main>
        <h1>Plan your photography session</h1>
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
            <label>Notes <textarea name="notes">{{ old('notes') }}</textarea></label>
            <button type="submit">Request my session</button>
        </form>
    </main>
</body>
</html>
