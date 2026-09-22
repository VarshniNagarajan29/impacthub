<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->with(['organisation', 'category', 'skills'])
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->paginate(9);

        return view('events.index', compact('events'));
    }
}