<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Event;
use App\Models\Category;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $today = now()->toDateString(); // Get today's date as YYYY-MM-DD

        if (Auth::user()->isAdmin() || Auth::user()->isTrainer()) {
            // Admins and trainers can see all events
            $events = Event::orderBy('start_date', 'asc')->with('coach')->get();
        } else {
            // Members can only see upcoming events
            $events = Event::whereDate('end_date', '>=', $today)
                           ->orderBy('start_date', 'asc')
                           ->with('coach')
                           ->get();
        }

        return view('events.index', compact('events'));
    }

    public function eventshow()
    {
        // Retrieve all events
        $events = Event::with('coach')->get();
        return view('events.eventshow', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        $coaches = Coach::all();
        $rooms = Room::all();
    
        return view('events.create', compact('categories', 'coaches', 'rooms'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'coach_id' => 'required|exists:coaches,id',
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Check for conflicts
        $conflict = Event::where('coach_id', $request->coach_id)
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                        })
                        ->orWhere('room_id', $request->room_id)
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                        })
                        ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors('The coach or room is already booked for the selected dates.');
        }

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
            'coach_id' => $request->coach_id,
            'room_id' => $request->room_id,
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function isAdmin() {
        $user = Auth::user();
        return $user->role == 'admin';
    }

    public function show(Event $event)
    {
        $event->load('coach');
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        $coaches = Coach::all();
        $rooms = Room::all();
        $event->load('coach');

        return view('events.edit', compact('event', 'categories', 'coaches', 'rooms'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'coach_id' => 'required|exists:coaches,id',
            'room_id' => 'required|exists:rooms,id',
        ]);
    
        // Check for conflicts
        $conflict = Event::where('id', '!=', $event->id)
                        ->where(function ($query) use ($request) {
                            $query->where('coach_id', $request->coach_id)
                                  ->where(function ($query) use ($request) {
                                      $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                                            ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                                  })
                                  ->orWhere('room_id', $request->room_id)
                                  ->where(function ($query) use ($request) {
                                      $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                                            ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                                  });
                        })
                        ->exists();
    
        if ($conflict) {
            return redirect()->back()->withErrors('The coach or room is already booked for the selected dates.');
        }
    
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'coach_id' => $request->coach_id,
            'room_id' => $request->room_id,
        ]);
    
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }
    
    public function istrainer() {
        $user = Auth::user();
        return $user->role == 'trainer';
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function searchE(Request $request)
    {
        $searchTerm = $request->input('search');

        $events = Event::where('title', 'like', '%' . $searchTerm . '%')
                       ->orWhere('description', 'like', '%' . $searchTerm . '%')
                       ->orWhere('type', 'like', '%' . $searchTerm . '%')
                       ->orWhere('start_date', 'like', '%' . $searchTerm . '%')
                       ->orWhere('end_date', 'like', '%' . $searchTerm . '%')
                       ->get();

        return view('events.eventshow', ['events' => $events]);
    }

    public function join(Request $request, Event $event)
    {
        $user = Auth::user();
        if ($user) {
            // Check if the user has already joined the event
            if ($event->users()->where('user_id', $user->id)->exists()) {
                return redirect()->route('events.index')->with('error', 'You have already joined this event.');
            }
            
            // Check if the room capacity is reached
            $room = $event->room;
            $currentParticipants = $event->users()->count();
            if ($currentParticipants >= $room->capacity) {
                return redirect()->route('events.index')->with('error', 'The room for this event is full.');
            }
            
            $event->users()->attach($user->id);
            return redirect()->route('events.index')->with('success', 'You have successfully joined the event.');
        }
        return redirect()->route('login');
    }

    public function unjoin(Event $event)
    {
        $user = Auth::user();
        if ($user) {
            if ($event->users()->where('user_id', $user->id)->exists()) {
                $event->users()->detach($user->id);
                return redirect()->route('events.index')->with('success', 'You have successfully unjoined the event.');
            }
            return redirect()->route('events.index')->with('error', 'You are not a participant of this event.');
        }
        return redirect()->route('login');
    }
}
