@extends('dashboard')

@section('content')

<html>

<head>
    <title>Create | Events</title>
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
<form action="{{ route('events.store') }}" method="POST">
    @csrf
    <h1>Create | Events</h1>
    <div class="case">
        <h3>PowerGym EVENTS</h3>
        <div class="grid">
            <label id="ic"><span class="material-icons-outlined">title</span> Title</label>
            <input type="text" id="title" name="title" required class="input">

            <label id="ic"><span class="material-icons-outlined">description</span> Description</label>
            <textarea id="description" name="description" required class="input"></textarea>

            <label id="ic"><span class="material-icons-outlined">category</span> Type</label>
            <select id="type" name="type" required class="input">
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <label id="ic"><span class="material-icons-outlined">event</span> Start Date and Time</label>
            <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}" required class="input">


            <label id="ic"><span class="material-icons-outlined">event</span> End Date</label>
            <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}" required class="input">

            <label id="ic"><span class="material-icons-outlined">person</span> Coach</label>
            <select id="coach_id" name="coach_id" required class="input">
                @foreach($coaches as $coach)
                    <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                @endforeach
            </select>

            <label id="ic"><span class="material-icons-outlined">meeting_room</span> Room</label>
            <select id="room_id" name="room_id" required class="input">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Error messages display -->
        @if ($errors->any())
            <div style="background-color: #FF4136; color: white; padding: 10px; border-radius: 5px; margin-top: 20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="btn-green">Create Event</button>
    </div>
</form>

</body>

</html>

@endsection
