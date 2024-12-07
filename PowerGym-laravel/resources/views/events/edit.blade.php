@extends('dashboard')

@section('content')

<html>

<head>
    <title>Update | Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <style>
      body, html {
        margin: 0;
        padding: 0;
        background-image: url("https://www.pixel4k.com/wp-content/uploads/2020/08/red-and-blue-broken-abstract_1596929088.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;/* Do not repeat the background */
        background-attachment: fixed;
        width: 100%;
        height: 100%;
        font-family: "Nunito", sans-serif;
        display: flex;
        flex-direction: column; /* Stack content vertically */
        align-items: center; /* Center content horizontally */
        justify-content: flex-start; /* Align content to the top */
    }
        h1 {
        font-size: 36px; /* Increased font size */
        color: white; /* Red color for headings */
        text-align: center;
        margin-top: 30px; /* Added some margin to the top */
    }

        .case {
        width: 700px; /* Increased width for a wider appearance */
        background-color: rgba(0, 0, 0, 0.5); /* Black background with transparency */
        border-radius: 10px; /* Increased border-radius */
        box-shadow: 0px 0px 8px #FF4136; /* Shadow with red color */
        margin: 0 auto;
        margin-top: 50px;
        overflow: hidden;
        padding: 40px; /* Increased padding */
        padding-bottom: 60px; /* Increased padding-bottom */
        color: white; /* Ensures text is readable against the darker background */
    }

        h3 {
        font-size: 40px; /* Increased font size */
        color: white; /* Red color for sub-headings */
    }

        .grid {
            display: grid;
            grid-template-columns: 15% 85%; /* Adjusted column sizes */
            grid-template-rows: auto; /* Auto-adjust row height */
            grid-gap: 20px; /* Increased grid gap for better spacing */
            margin-top: 20px; /* Added some margin to the top inside the grid */
        }

        #ic {
            font-size: 20px; /* Increased font size */
            color: white; /* Adjusted icon color to match the theme */
        }

        .input, select, textarea {
            background-color: #2C2C54; /* Darker background for inputs */
            color: white; /* White text color for better contrast */
            width: 100%;
            padding: 10px; /* Increased padding for better appearance */
            border: 2px solid #FF4136; /* Red border */
            border-radius: 5px; /* Rounded borders for inputs */
            margin-top: 5px; /* Adjusted margin top */
            font-size: 16px; /* Increased font size */
        }

        .btn-green {
            background-color: #FF4136;
            width: 100%;
            padding: 15px 0; /* Adjust padding for bigger button */
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 20px; /* Increased font size */
            cursor: pointer; /* Cursor pointer for better UX */
            transition: 0.3s;
        }

        .btn-green:hover {
            opacity: 0.7;
        }
    </style>
</head>
<body>
<form action="{{ route('events.update', $event) }}" method="POST">
    @csrf
    @method('PUT')

    <h1>Edit Event</h1>
    <div class="grid">
        <!-- Error messages display -->
        @if ($errors->any())
            <div style="background-color: #FF4136; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="title">Title</label>
        <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $event->title) }}" required autofocus>

        <label for="description">Description</label>
        <textarea id="description" class="form-control" name="description" required>{{ old('description', $event->description) }}</textarea>

        <label for="type">Type</label>
        <select id="type" name="type" required>
            @foreach($categories as $category)
                <option value="{{ $category->name }}" {{ $category->name == $event->type ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label for="start_date">Start Date</label>
        <input id="start_date" type="datetime-local" class="form-control" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d')) }}" required>

        <label for="end_date">End Date</label>
        <input id="end_date" type="datetime-local" class="form-control" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d')) }}" required>

        <label for="coach_id">Coach</label>
        <select id="coach_id" name="coach_id" required>
            @foreach($coaches as $coach)
                <option value="{{ $coach->id }}" {{ $coach->id == $event->coach_id ? 'selected' : '' }}>
                    {{ $coach->name }}
                </option>
            @endforeach
        </select>

        <label for="room_id">Room</label>
        <select id="room_id" name="room_id" required>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ $room->id == $event->room_id ? 'selected' : '' }}>
                    {{ $room->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Event</button>
</form>


</body>
</html>

@endsection