<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ImpactHub')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-zinc-950 antialiased">
    <header class="border-b border-zinc-200">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-8" aria-label="Main navigation">
            <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight">ImpactHub</a>

            <div class="flex items-center gap-6 text-sm font-medium text-zinc-600">
                <a href="{{ route('events.index') }}" class="transition hover:text-zinc-950">
                    Explore opportunities
                </a>

                @auth
                    <span class="text-zinc-500">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="transition hover:text-zinc-950"
                        >
                            Log out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="transition hover:text-zinc-950">
                        Log in
                    </a>

                    <a href="{{ route('register') }}" class="transition hover:text-zinc-950">
                        Register
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>