@extends('layouts.app')

@section('title', 'Explore opportunities | ImpactHub')

@section('content')
    <section class="border-b border-zinc-800 bg-zinc-950 text-white">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
            <p class="mb-5 text-sm font-semibold uppercase tracking-[0.18em] text-zinc-400">Volunteer locally</p>
            <h1 class="max-w-3xl text-5xl font-semibold tracking-tight sm:text-6xl lg:text-7xl">
                Find a way to make an impact.
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-zinc-300">
                Browse local opportunities where your time, skills, and energy can support the community.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-14 lg:px-8 lg:py-20">
        <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-zinc-500">Make time for something meaningful</p>
                <h2 class="mt-2 text-3xl font-semibold tracking-tight">Upcoming opportunities</h2>
            </div>
            <p class="text-sm text-zinc-500">{{ $events->total() }} opportunities available</p>
        </div>

        @if ($events->isEmpty())
            <div class="border border-dashed border-zinc-300 px-6 py-12 text-center text-zinc-600">
                There are no upcoming opportunities at the moment.
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="flex min-h-80 flex-col border border-zinc-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-zinc-400 hover:shadow-md">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-zinc-500">
                            {{ $event->category->name }}
                        </p>

                        <h2 class="mt-5 text-2xl font-semibold leading-tight tracking-tight">
                            {{ $event->title }}
                        </h2>

                        <p class="mt-3 flex-1 text-sm leading-6 text-zinc-600">
                            {{ $event->description }}
                        </p>

                        <dl class="mt-6 space-y-2 border-t border-zinc-200 pt-5 text-sm">
                            <div class="flex justify-between gap-4">
                                <dt class="text-zinc-500">When</dt>
                                <dd class="text-right font-medium">{{ $event->starts_at->format('D, d M Y, g:i A') }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-zinc-500">Where</dt>
                                <dd class="text-right font-medium">{{ $event->location }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-zinc-500">Hosted by</dt>
                                <dd class="text-right font-medium">{{ $event->organisation->name }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-zinc-500">Places</dt>
                                <dd class="text-right font-medium">{{ $event->capacity }}</dd>
                            </div>
                        </dl>

                        @if ($event->skills->isNotEmpty())
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($event->skills as $skill)
                                    <span class="border border-zinc-300 px-2.5 py-1 text-xs font-medium text-zinc-600">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $events->onEachSide(1)->links() }}
            </div>
        @endif
    </section>
@endsection