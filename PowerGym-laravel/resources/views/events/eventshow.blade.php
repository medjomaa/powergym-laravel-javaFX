@extends('frontend')
@section('title', 'Power Gym - Events')
@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            width: 100%;
            height: auto;
            margin: 0;
            padding-bottom: 50px;
            background-color: #1b1b32;
            color: rgb(192,192,192);
            font-family: Cambria;
            font-size: 16px;
            background-image: url("https://www.pixel4k.com/wp-content/uploads/2020/08/red-and-blue-broken-abstract_1596929088.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .welcome {
            margin: 40px auto;
            width: 80%;
            border: 2px solid #ffffff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7);
        }
        .welcome h2 {
            color: #ffffff;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .welcome p {
            font-size: 14px;
        }
        .search {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .search input[type="text"] {
            width: 300px;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #ffffff;
            background-color: rgba(255, 255, 255, 0.5);
            color: #000000;
        }
        .search button {
            padding: 10px 20px;
            background-color: #cc0000;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search button:hover {
            background-color: #ff4d4d;
        }
        .events-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 170px;
            margin-bottom: 200px;
        }
        .event {
            width: 300px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            color: #ffffff;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }
        .event h2 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
        }
        .event p {
            margin: 10px 0;
            color: #ffffff;
        }
        .event .Join-button {
            width: 100%;
            padding: 10px;
            background-color: #cc0000;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            align-self: center;
        }
        .event .Join-button:hover {
            background-color: #ff4d4d;
        }
        .event-date {
            font-weight: bold;
            color: #FFC107;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 2px 5px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="welcome">
        <h2>Welcome to Our Gym Events</h2>
        <p>Discover the latest events happening at Power Gym. Join us to get the most out of your fitness journey!</p>
        <div class="search">
            <form action="{{ route('events.searchE') }}" method="GET">
                <input type="text" name="search" placeholder="Search events...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="events-container">
        @if(count($events) > 0)
            @foreach($events as $event)
                <div class="event">
                    <h2>{{ $event->title }}</h2>
                    <p>{{ $event->description }}</p>
                    <p>Type: {{ $event->type }}</p>
                    <p>
                        From <span class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->format("F j, Y") }}</span>
                        To <span class="event-date">{{ \Carbon\Carbon::parse($event->end_date)->format("F j, Y") }}</span>
                    </p>
                    <form action="{{ route('events.join', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="Join-button">Join</button>
                    </form>
                </div>
            @endforeach
        @else
            <p>No events found.</p>
        @endif
    </div>
</body>
</html>
@endsection
