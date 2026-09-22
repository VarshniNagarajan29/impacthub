@extends('layouts.app')

@section('title', 'Log in | ImpactHub')

@section('content')
    <section class="mx-auto max-w-xl px-6 py-16">
        <h1 class="text-4xl font-semibold tracking-tight">
            Welcome back
        </h1>

        <p class="mt-3 text-zinc-600">
            Log in to manage your ImpactHub activity.
        </p>

        @if ($errors->any())
            <div class="mt-6 border border-red-300 bg-red-50 p-4 text-sm text-red-800">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium">
                    Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="mt-2 block w-full border border-zinc-300 px-3 py-2"
                >

                @error('email')
                    <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium">
                    Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="mt-2 block w-full border border-zinc-300 px-3 py-2"
                >

                @error('password')
                    <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="bg-zinc-950 px-5 py-3 text-sm font-semibold text-white"
            >
                Log in
            </button>
        </form>
    </section>
@endsection