<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::published()->upcoming()->orderBy('starts_at')->get();

        return view('events.index', ['events' => $events]);
    }
}
