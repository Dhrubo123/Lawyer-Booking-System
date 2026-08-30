<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if ($favicon = \App\Models\Setting::valueFor('favicon_url'))
        <link rel="icon" href="{{ $favicon }}">
    @endif

    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body>
    @inertia
</body>
</html>
