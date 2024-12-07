@extends('dashboard')

@section('content')
<div class="container">
    <h2 class="section-title">Edit Schedule</h2>
    <form action="{{ route('schedule.edit', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="day">Day:</label>
            <input type="text" id="day" name="day" class="form-control" value="{{ $schedule->day }}" required>
        </div>
        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" class="form-control" value="{{ $schedule->time }}" required>
        </div>
        <div class="form-group">
            <label for="class_type">Class Type:</label>
            <input type="text" id="class_type" name="class_type" class="form-control" value="{{ $schedule->class_type }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control">{{ $schedule->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Schedule</button>
    </form>
</div>
<style> body {
        font-family: 'Open Sans', sans-serif;
        background-image: url('https://images.unsplash.com/photo-1612090295965-e506249ccecc?q=80&w=3324&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
        color: #fff; /* Keep text color white for contrast */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Add shadow to text for better readability */
        background-size: cover; /* Cover the entire page */
        background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Do not repeat the background */
        margin: 0;
        padding: 20px;
        text-align: center;
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
        color: #fff;
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

    form {
        margin-top: 20px;
        background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent white background for forms */
        padding: 20px;
        border-radius: 5px;
    }

    form .form-group {
        margin-bottom: 15px;
    }

    form label {
        color: #fff;
    }

    form input[type="text"],
    form input[type="time"],
    form textarea,
    form .btn {
        background-color: #333; /* Dark background for form elements */
        color: #fff; /* White text */
        border: none;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 3px;
    }

    form .btn-primary {
        background-color: #007bff; /* Blue primary button */
    }

    form .btn-danger {
        background-color: #dc3545; /* Red danger button */
    }

    form .btn-primary,
    form .btn-danger {
        margin-right: 10px;
    }

    form .btn-primary:hover,
    form .btn-danger:hover {
        opacity: 0.8;
    }</style>
@endsection
