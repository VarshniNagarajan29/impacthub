@extends('layouts.app')

@section('title', 'Create an account | ImpactHub')

@section('content')
    <section class="mx-auto max-w-xl px-6 py-16">
        <h1 class="text-4xl font-semibold tracking-tight">
            Create your account
        </h1>

        <p class="mt-3 text-zinc-600">
            Register to discover local volunteer opportunities.
        </p>
        @if ($errors->any())
    <div class="mb-6 border border-red-300 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-semibold">Please correct the following errors:</p>

        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form method="POST" action="{{ route('register.store')}}" class="mt-8 space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium">
                    Name
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    required
                    class="mt-2 block w-full border border-zinc-300 px-3 py-2"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium">
                    Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    class="mt-2 block w-full border border-zinc-300 px-3 py-2"
                >
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
                    class="mt-2 block w-full border border-zinc-300 px-3 py-2"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium">
                    Confirm password
                </label>

                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    class="mt-2 block w-full border border-zinc-300 px-3 py-2"
                >
            </div>

            <button
                type="submit"
                class="bg-zinc-950 px-5 py-3 text-sm font-semibold text-white"
            >
                Create account
            </button>
        </form>
    </section>
@endsection