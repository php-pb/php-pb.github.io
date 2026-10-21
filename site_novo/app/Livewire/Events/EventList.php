<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class EventList extends Component
{
    public string $filter = 'all';

    public $events = [];

    protected $queryString = [
        'filter' => ['except' => 'all'],
    ];

    public function mount(): void
    {
        $this->loadEvents();
    }

    public function updatedFilter(): void
    {
        $this->loadEvents();
    }

    private function loadEvents(): void
    {
        $query = Event::published();

        match ($this->filter) {
            'upcoming' => $query->upcoming()->orderBy('starts_at'),
            'past' => $query->past()->orderBy('starts_at', 'desc'),
            default => $query->orderBy('starts_at', 'desc'),
        };

        $this->events = $query->get();
    }

    public function render()
    {
        return view('livewire.events.event-list');
    }
}
