@extends('frontend')

@section('content')
<div class="container">
    <h2 class="section-title">Weekly Schedule</h2>
    <div class="schedule-table">
        <table class="table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Class Type</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedSchedules as $day => $schedules)
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->first ? $day : '' }}</td>
                            <td>{{ $schedule->time }}</td>
                            <td>{{ $schedule->class_type }}</td>
                            <td>{{ $schedule->description }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 class="section-title">Upcoming Events</h2>
    <div class="events-table">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formattedEvents as $event)
                    <tr>
                        <td>{{ $event['title'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($event['start'])->format('Y-m-d H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($event['end'])->format('Y-m-d H:i') }}</td>
                        <td>{{ $event['description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #000;
        color: #fff;
    }

    .container {
        max-width: 960px;
        margin: 0 auto;
        padding: 20px;
    }

    .section-title {
        font-size: 28px;
        margin-bottom: 15px;
        text-transform: uppercase;
        font-weight: bold;
        color: #fff; /* Ensure text is white */
    }

    .schedule-table, .events-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent white background */
        border: 1px solid rgba(255, 255, 255, 0.1); /* Semi-transparent white border */
    }

    .schedule-table th, .events-table th, .schedule-table td, .events-table td {
        border: 1px solid rgba(255, 255, 255, 0.1); /* Semi-transparent white border */
        padding: 12px;
        color: #fff; /* Ensure text is white */
    }

    .schedule-table th, .events-table th {
        background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent white background for headers */
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
    }

    .schedule-table td, .events-table td {
        text-align: center;
        font-size: 16px;
    }
</style>


@endsection
