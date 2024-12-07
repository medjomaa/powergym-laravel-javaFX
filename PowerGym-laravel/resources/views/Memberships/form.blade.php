@extends('frontend')

@section('title', 'Power Gym - Home')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYM Membership Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2E8B57; /* Dark green background color for a gym theme */
            background-image: url("https://i.pinimg.com/originals/fe/e5/46/fee54690963240994bf2b3c6342bc89a.jpg"); /* Replace with your gym-themed background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for form container */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 50px;
            width: 80%; /* Adjusted to make container wider for better form layout */
            max-width: 600px; /* Limit container width for larger screens */
            margin: 0 auto; /* Center container horizontally */
        }
        h2 {
            color: #cc0000; /* Red heading color to stand out */
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            margin-top: 20px; /* Increased margin top for better spacing */
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #333; /* Darkened label color for better contrast */
        }
        .btn-container {
    text-align: center; /* Center aligns buttons */
}

.btn-container .btn {
    width: 45%; /* Equal width for both buttons */
    margin: 0 5px; /* Margin between buttons */
}

        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>GYM Membership Form</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('membership.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
            </div>

            <div class="form-group">
                <label for="membership_duration">Membership Duration</label>
                <select class="form-control" id="membership_duration" name="membership_duration" required>
                    <option value="1" {{ old('membership_duration') == '1' ? 'selected' : '' }}>1 Month (90 DT)</option>
                    <option value="3" {{ old('membership_duration') == '3' ? 'selected' : '' }}>3 Months (250 DT)</option>
                    <option value="6" {{ old('membership_duration') == '6' ? 'selected' : '' }}>6 Months (520 DT)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="paid_status">Payment Status</label>
                <select class="form-control" id="paid_status" name="paid_status" required>
                    <option value="0" {{ old('paid_status') == '0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ old('paid_status') == '1' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>

            <div class="form-group btn-container">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('login') }}" class="btn btn-secondary">Sign In</a>
    </div>
        </form>
    </div>
</body>
</html>

@endsection
