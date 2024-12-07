<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Event2Controller extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
    
        // Retrieve events that are upcoming or on the current day
        $events = Event::whereDate('end_date', '>=', $today)
                       ->orderBy('start_date', 'asc')
                       ->with('coach')
                       ->get();
    
        // Format events for FullCalendar
        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => Carbon::parse($event->start_date)->toIso8601String(),
                'end' => Carbon::parse($event->end_date)->toIso8601String(),
                // Add more fields if needed
            ];
        });
    
        // Retrieve joined events for the current user (if authenticated)
        $joinedEvents = Auth::check() ? Auth::user()->events : null;
    
        return view('calendar.calendar', compact('events', 'formattedEvents', 'joinedEvents'));
    }
    

    public function unjoin(Request $request, Event $event)
    {
        $user = Auth::user();
        if ($user) {
            // Check if the user has joined the event
            if ($event->users()->where('user_id', $user->id)->exists()) {
                $event->users()->detach($user->id);
                return redirect()->route('calendar.index')->with('success', 'You have successfully unjoined the event.');
            }
            return redirect()->route('calendar.index')->with('error', 'You are not a participant of this event.');
        }
        return redirect()->route('login');
    }

    // Other controller methods here...

    public function joinedEvents()
{
    $joinedEvents = Auth::check() ? Auth::user()->events : collect([]);
    return view('calendar.joined_events', compact('joinedEvents'));
}



    
public function myMethod()
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // The user is logged in
        $userName = Auth::user()->name;
        // Continue with your logic, now safely using $userName
    } else {
        // User is not authenticated, redirect with a message
        return redirect('/registration')->with('error', 'You need to create an account or log in.');
    }
}
public function __construct()
{
    $this->middleware('auth');
}

}
