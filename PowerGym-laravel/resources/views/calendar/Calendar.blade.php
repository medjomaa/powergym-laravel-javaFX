@extends('dashboard')

@section('title', 'Power Gym - Calendar')

@section('content')
<div class="calendar-section">
    <div class="calendar-header">
        <h2>Power Gym Calendar</h2>
        <div class="calendar-buttons">
            <a href="{{ route('events.joined') }}" class="btn btn-primary">View Joined Events</a>
            @if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTrainer()))
                <a href="{{ route('coach.calendar', ['coachId' => Auth::user()->id]) }}" class="btn btn-success">View Coach Schedule</a>
            @endif
        </div>
    </div>
    <p>Stay updated with our latest events and activities. The calendar below showcases all our upcoming events.</p>
    <div id="calendar" class="transparent-calendar">
        <!-- Calendar will be rendered here -->
    </div>
</div>

{{-- Include FullCalendar's CSS and JS from CDN --}}
<link href='https://unpkg.com/fullcalendar@5.9.0/main.min.css' rel='stylesheet' />
<script src='https://unpkg.com/fullcalendar@5.9.0/main.min.js'></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
body {
    background-color: #1e1e2f; /* Dark background color */
    color: #ffffff; /* Default text color */
    font-family: 'Arial', sans-serif;
}

.calendar-section {
    width: 100%;
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: rgba(0, 0, 0, 0.85);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.calendar-section h2 {
    font-size: 36px;
    font-weight: bold;
    color: #007bff; /* Blue color for headings */
    text-shadow: 2px 2px #ff0000; /* Red shadow for headings */
}

.calendar-buttons a {
    margin-left: 10px;
}

.calendar-section p {
    font-size: 16px;
    line-height: 1.6;
    color: #f8f9fa; /* Light gray color for paragraphs */
    margin-bottom: 20px;
}

.calendar-section .btn {
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #007bff;
    color: #fff;
    transition: background-color 0.3s ease;
}

.calendar-section .btn:hover {
    background-color: #0056b3;
}

#calendar {
    width: 100%;
    height: 100%; /* Fill the height of the calendar section */
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 10px;
}

.fc-toolbar-title {
    color: #00ff00; /* Green color for the calendar title */
}

.fc-daygrid-day {
    background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent cells */
    border-color: #00ff00; /* Green borders for cells */
    color: #ffffff; /* White color for cell numbers */
}

.fc-daygrid-day.fc-day-today {
    background-color: rgba(0, 123, 255, 0.5); /* Blue for today */
    position: relative;
}

.fc-day-today::after {
    content: 'Today';
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: #ff0000; /* Red background for "Today" label */
    color: #ffffff; /* White text for "Today" label */
    padding: 2px 5px;
    border-radius: 5px;
    font-size: 12px;
}

.fc-event-title {
    color: #ffffff; /* Ensure text is white for better visibility */
}

.fc-event {
    background-color: #dc3545; /* Red background for events */
    border: none;
    border-radius: 5px;
    padding: 5px;
}

.fc-event .event-icon {
    margin-right: 5px; /* Space between icon and text */
}

.past-event {
    text-decoration: line-through; /* Crosses out the event title */
    opacity: 0.6; /* Optionally, make past events less prominent */
    color: #888888; /* Gray color for past events */
}

/* Responsive adjustments */
@media (min-width: 576px) {
    .calendar-section {
        flex-direction: row;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            events: @json($formattedEvents),
            eventContent: function(arg) {
                let isPast = new Date(arg.event.start) < new Date();
                let title = document.createElement('div');
                title.classList.add('fc-event-title');
                if (isPast) {
                    title.classList.add('past-event'); // Add this class for past events
                }
                title.innerHTML = '<i class="fas fa-calendar-alt event-icon"></i>' + arg.event.title;
                let description = document.createElement('div');
                description.classList.add('fc-event-description');
                description.innerHTML = arg.event.extendedProps.description || '';
                return { domNodes: [title, description] };
            },
        });
        calendar.render();
    });
</script>
@endsection
