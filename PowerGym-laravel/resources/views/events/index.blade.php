@extends('dashboard')

@section('content')
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">
<style>
    body {
        width: 100%;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
        background-color: #1b1b32;
        color: rgb(192, 192, 192);
        font-family: 'Arial', sans-serif;
        font-size: 16px;
        background-image: url("https://www.pixel4k.com/wp-content/uploads/2020/08/red-and-blue-broken-abstract_1596929088.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 10px;
    }

    .table-title {
        padding: 20px;
        background: linear-gradient(45deg, #8B0000, #00008B);
        color: #fff;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    }

    .table-title h2 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    .table-title .btn {
        background-color: #8B0000;
        color: #fff;
        font-size: 18px;
        border: 2px solid #8B0000;
        border-radius: 50px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .table-title .btn:hover {
        background-color: #00008B;
        border-color: #00008B;
    }

    .intro-text {
        margin: 20px 0;
        font-size: 18px;
        line-height: 1.6;
        text-align: justify;
        background: rgba(255, 255, 255, 0.1);
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .card {
        background-color: rgba(340, 0, 0, 0.5);
        padding: 20px;
        width: calc(25% - 20px);
        margin: 10px 0;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 400px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }

    .card-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #f8b400; 
        font-family: 'Georgia', serif;
        text-align: center;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .card-description {
        font-size: 16px;
        margin-bottom: 10px;
        flex-grow: 1;
        color: rgba(255, 255, 255, 0.8);
        font-family: 'Verdana', sans-serif;
        text-align: justify;
        line-height: 1.5;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .card-dates {
        font-size: 14px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.6);
        font-family: 'Courier New', monospace;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .card-date-style {
        color: rgba(255, 255, 255, 0.6);
        display: inline-block;
    }

    .card-actions {
        align-self: flex-end;
    }

    .card-actions .btn {
        background-color: rgba(0, 0, 0, 0.5);
        color: rgba(255, 0, 0, 0.7);
        font-size: 14px;
        border: 2px solid rgba(255, 0, 0, 0.7);
        border-radius: 5px;
        margin-left: 10px;
        padding: 5px 10px;
        transition: all 0.3s ease;
    }

    .card-actions .btn:hover {
        background-color: rgba(255, 0, 0, 0.7);
        color: #fff;
    }

    .alert-danger {
        background: rgba(255, 0, 0, 0.7);
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        width: 100%;
    }

    .alert-danger ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .alert-danger li {
        margin-bottom: 10px;
    }
</style>
<div class="container">
    <div class="table-title">
        <h2>Events</h2>
        @if (Auth::user()->isAdmin() || Auth::user()->isTrainer())
        <a href="{{ route('events.create') }}" class="btn"><i class="fas fa-plus-circle"></i> Add New Event</a>
        @endif
    </div>
    <div class="intro-text">
        <p>Welcome to the Events Page! Here you can find all the upcoming events. Each event is crafted to provide an enriching experience for you. Feel free to explore and join any event that interests you!</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="cards-container">
    @foreach($events as $event)
    @if (Auth::user()->isAdmin() || Auth::user()->isTrainer() || $event->end_date >= now())
        <div class="card">
            <div class="card-title">{{ $event->title }}</div>
            <div class="card-description">{{ $event->description }}</div>
            <div class="card-dates">
                <span class="card-date-style"><i class="fas fa-calendar-alt"></i> {{ $event->start_date }}</span>
                <span class="card-date-style"><i class="fas fa-calendar-check"></i> {{ $event->end_date }}</span>
                @if($event->coach)
                    <span class="card-date-style"><i class="fas fa-user"></i> Coach: {{ $event->coach->name }}</span>
                @endif
                @if($event->room)
                    <span class="card-date-style"><i class="fas fa-door-open"></i> Room: {{ $event->room->name }} (Capacity: {{ $event->room->capacity }})</span>
                @endif
            </div>
            <div class="card-actions">
                @if (Auth::user()->isAdmin() || Auth::user()->isTrainer())
                    <a href="{{ route('events.edit', $event->id) }}" class="btn"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn"><i class="fas fa-trash-alt"></i> Delete</button>
                    </form>
                @endif
                @if ($event->users->contains(Auth::user()))
                    <form action="{{ route('events.unjoin', $event) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sign-out-alt"></i> Unjoin
                        </button>
                    </form>
                @else
                    <form action="{{ route('events.join', $event) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-sign-in-alt"></i> Join
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif
@endforeach

    </div>
</div>

@endsection
