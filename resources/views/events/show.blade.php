@extends('layouts.app')

@section('title', $event->title . ' | ImpactHub')

@section('content')
    <section class="border-b border-zinc-200 bg-zinc-950 text-white">
        <div class="mx-auto max-w-5xl px-6 py-16 lg:px-8 lg:py-24">
            <a
                href="{{ route('events.index') }}"
                class="text-sm font-medium text-zinc-400 transition hover:text-white"
            >
                &larr; Back to opportunities
            </a>

            <p class="mt-12 text-sm font-semibold uppercase tracking-[0.18em] text-zinc-400">
                {{ $event->category->name }}
            </p>

            <h1 class="mt-5 max-w-4xl text-4xl font-semibold tracking-tight sm:text-6xl">
                {{ $event->title }}
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-zinc-300">
                Hosted by {{ $event->organisation->name }}
            </p>
        </div>
    </section>

    <section class="mx-auto grid max-w-5xl gap-12 px-6 py-14 lg:grid-cols-[1fr_280px] lg:px-8 lg:py-20">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight">About this opportunity</h2>

            <p class="mt-5 whitespace-pre-line leading-8 text-zinc-600">
                {{ $event->description }}
            </p>

            @if ($event->skills->isNotEmpty())
                <div class="mt-12">
                    <h2 class="text-2xl font-semibold tracking-tight">Useful skills</h2>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($event->skills as $skill)
                            <span class="border border-zinc-300 px-3 py-1.5 text-sm text-zinc-600">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <aside class="h-fit border border-zinc-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold tracking-tight">Opportunity details</h2>

            <dl class="mt-6 space-y-5 text-sm">
                <div>
                    <dt class="text-zinc-500">When</dt>
                    <dd class="mt-1 font-medium">
                        {{ $event->starts_at->format('l, d F Y, g:i A') }}
                    </dd>
                </div>

                <div>
                    <dt class="text-zinc-500">Where</dt>
                    <dd class="mt-1 font-medium">
                        {{ $event->location }}
                    </dd>
                </div>

                <div>
                    <dt class="text-zinc-500">Volunteer places</dt>
                    <dd class="mt-1 font-medium">
                        {{ $event->capacity }}
                    </dd>
                </div>

                <div>
                    <dt class="text-zinc-500">Organisation</dt>
                    <dd class="mt-1 font-medium">
                        {{ $event->organisation->name }}
                    </dd>
                </div>
            </dl>

            <a
                href="{{ route('login') }}"
                class="mt-8 block bg-zinc-950 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-zinc-700"
            >
                Log in to register
            </a>
        </aside>
    </section>
@endsection