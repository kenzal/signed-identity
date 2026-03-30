@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'Signed Identity') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" href="{{ asset('favicon-32.png') }}/" sizes="32x32">
        <link rel="icon" href="{{ asset('favicon-16.png') }}" sizes="16x16">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased">
        <div class="mx-auto max-w-5xl px-6 py-8">
            <header class="mb-8 border-b border-zinc-200 pb-5">
                <div class="inline-flex items-center gap-4">
                    <a href="{{ url('/') }}" class="inline-block" aria-label="Signed Identity home">
                        <img src="{{ asset('images/signed-identity.svg') }}" alt="Signed Identity" class="h-10 w-auto">
                    </a>
                    <p id="page-title" class="font-brand text-xl font-semibold tracking-tight text-zinc-900">
                        {{ $title ?? config('app.name', 'Signed Identity') }}
                    </p>
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

