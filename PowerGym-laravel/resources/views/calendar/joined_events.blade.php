@extends('dashboard')

@section('title', 'Power Gym - Joined Events')

@section('content')
<div class="events-section">
    <div class="events-header">
        <h2>Joined Events</h2>
        <div class="events-buttons">
            <a href="{{ route('calendar.index') }}" class="btn btn-primary">View Events Calendar</a>
            @if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTrainer()))
                <a href="{{ route('coach.calendar', ['coachId' => Auth::user()->id]) }}" class="btn btn-success">View Coach Schedule</a>
            @endif
        </div>
    </div>
    <p>Here is the list of events you have joined.</p>
    <div class="upcoming-events">
        @if ($joinedEvents->isEmpty())
            <p>You have not joined any events yet.</p>
        @else
            @foreach ($joinedEvents as $event)
            <div class="upcoming-event">
                <div class="event-details">
                    <div class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->format('M d') }}</div>
                    <div class="event-title">{{ $event->title }}</div>
                    @if($event->coach)
                        <div class="event-coach"><i class="fas fa-user"></i> Coach: {{ $event->coach->name }}</div>
                    @endif
                </div>
                <div class="card-actions">
                    <form action="{{ route('calendar.unjoin', $event) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Unjoin</button>
                    </form>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
body {
    background-color: #1e1e2f; /* Dark background color */
    color: #ffffff; /* Default text color */
    font-family: 'Arial', sans-serif;
}

.events-section {
    width: 100%;
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: rgba(0, 0, 0, 0.85);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.events-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.events-header h2 {
    font-size: 36px;
    font-weight: bold;
    color: #007bff; /* Blue color for headings */
    text-shadow: 2px 2px #ff0000; /* Red shadow for headings */
}

.events-buttons a {
    margin-left: 10px;
}

.events-section p {
    font-size: 16px;
    line-height: 1.6;
    color: #f8f9fa; /* Light gray color for paragraphs */
    margin-bottom: 20px;
}

.upcoming-events {
    display: flex;
    flex-direction: column;
}

.upcoming-event {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent background */
    color: #fff;
    padding: 10px;
    margin-bottom: 10px;
    border-left: 5px solid #007bff; /* Blue border */
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.upcoming-event:hover {
    background-color: rgba(255, 255, 255, 0.2); /* Lighter background on hover */
}

.event-details {
    flex: 1;
}

.event-date {
    font-weight: bold;
    font-size: 20px;
    color: #00ff00; /* Green color for event dates */
}

.event-title {
    font-size: 18px;
    color: #ffffff; /* White color for event titles */
}

.event-coach {
    font-size: 16px;
    color: #ffffff; /* White color for event coach */
}

.card-actions {
    margin-left: 10px; /* Adjust as needed */
}

.btn {
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
}

/* Responsive adjustments */
@media (min-width: 576px) {
    .events-section {
        margin: 0 10px;
    }
}
</style>
@endsection
