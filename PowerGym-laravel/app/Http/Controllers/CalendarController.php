<?php

namespace App\Http\Controllers;

use App\Models\GymSchedule;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    // Method to show the general calendar with schedules and events
    public function showSchedule()
    {
        // Fetch the gym schedules
        $gymSchedules = GymSchedule::orderBy('day')
                                   ->orderBy('time')
                                   ->get();
    
        // Group schedules by day
        $groupedSchedules = $gymSchedules->groupBy('day');
    
        // Fetch events for the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
    
        $events = Event::whereBetween('start_date', [$startOfWeek, $endOfWeek])
                       ->orderBy('start_date')
                       ->get();
    
        // Format events for FullCalendar
        $formattedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => Carbon::parse($event->start_date)->toIso8601String(),
                'end' => Carbon::parse($event->end_date)->toIso8601String(),
                'description' => $event->description,
            ];
        });
    
        return view('calendar.general', compact('groupedSchedules', 'formattedEvents'));
    }

    // Method to show the schedule table (alternative view)
    public function showScheduleTable()
    {
        // Fetch the gym schedules
        $gymSchedules = GymSchedule::orderBy('day')
                                   ->orderBy('time')
                                   ->get();

        // Group schedules by day
        $groupedSchedules = $gymSchedules->groupBy('day');

        // Fetch events for the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $events = Event::whereBetween('start_date', [$startOfWeek, $endOfWeek])
                       ->orderBy('start_date')
                       ->get();

        // Format events for display
        $formattedEvents = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_date->format('Y-m-d H:i:s'),
                'end' => $event->end_date->format('Y-m-d H:i:s'),
                'description' => $event->description,
            ];
        });

        return view('calendar.schedule_table', compact('groupedSchedules', 'formattedEvents'));
    }
    public function showCreateForm()
    {
        return view('calendar.create');
    }
    // Method to create a new schedule
    public function createSchedule(Request $request)
    {
        // Validate the request data
        $request->validate([
            'day' => 'required',
            'time' => 'required',
            'class_type' => 'required',
            'description' => 'nullable',
        ]);

        // Create a new gym schedule
        GymSchedule::create([
            'day' => $request->day,
            'time' => $request->time,
            'class_type' => $request->class_type,
            'description' => $request->description,
        ]);

        return redirect()->route('schedule')->with('success', 'Gym schedule created successfully!');
    }


    // Method to show the edit form for a schedule
    public function editSchedule($id)
    {
        // Find the gym schedule
        $schedule = GymSchedule::findOrFail($id);

        return view('calendar.update', compact('schedule'));
    }

    // Method to update a schedule
    public function updateSchedule(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'day' => 'required',
            'time' => 'required',
            'class_type' => 'required',
            'description' => 'nullable',
        ]);

        // Find the gym schedule
        $schedule = GymSchedule::findOrFail($id);

        // Update the gym schedule
        $schedule->update([
            'day' => $request->day,
            'time' => $request->time,
            'class_type' => $request->class_type,
            'description' => $request->description,
        ]);

        return redirect()->route('schedule')->with('success', 'Gym schedule updated successfully!');
    }

    // Method to delete a schedule
    public function deleteSchedule($id)
    {
        // Find the gym schedule
        $schedule = GymSchedule::findOrFail($id);

        // Delete the gym schedule
        $schedule->delete();

        return redirect()->route('schedule')->with('success', 'Gym schedule deleted successfully!');
    }
}
