<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Coach;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CoachCalendarController extends Controller
{
    public function show($coachId)
    {
        $today = now()->toDateString();

        // Retrieve events for the selected coach that are upcoming or on the current day
        $events = Event::where('coach_id', $coachId)
                       ->whereDate('end_date', '>=', $today)
                       ->orderBy('start_date', 'asc')
                       ->with('coach')
                       ->get();

        // Format events for FullCalendar
        $formattedCoachEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => Carbon::parse($event->start_date)->toIso8601String(),
                'end' => Carbon::parse($event->end_date)->toIso8601String(),
                // Add more fields if needed
            ];
        });

        // Retrieve coach details
        $coach = Coach::findOrFail($coachId);

        return view('calendar.coach_calendar', compact('formattedCoachEvents', 'coach'));
    }
    public function isAdmin() {
        $user = Auth::user();
        return  $this->$user->role == 'admin';  // Check if the user is an admin by email
    }
    public function istrainer() {
        $user = Auth::user();
        return $user->role == 'trainer';  // Check if the user is an admin by role
    }
    
}
