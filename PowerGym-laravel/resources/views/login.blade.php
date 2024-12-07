@extends('frontend')
@section('title','Login')
@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title','custom auth laravel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
    body {
        background-color: #2E8B57; /* Dark green background color for a gym theme */
        background-image: url("https://i.pinimg.com/originals/fe/e5/46/fee54690963240994bf2b3c6342bc89a.jpg"); /* Replace the URL with your gym-themed background image */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        height: 100vh;
        margin: 0;
        padding: 20px 20px 20px 0; /* Padding added to top, right, and bottom */
        align-items: center;
        justify-content: flex-end; /* Align box to the right */
    }

    .login-box {
        background-color: rgba(255, 255, 255, 0.5); /* Increased transparency */
        border-radius: 50px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        padding: 10px 20px 20px; /* Adjusted padding for wider fields */
        width: 600px; /* Increased box width */
        max-height: calc(100% - 40px); /* Adjust height to account for body padding */
        display: flex;
        flex-direction: column;
        overflow-y: auto; /* Ensure content is scrollable if it exceeds the box height */
    }

    .logo, .log-in-text {
        text-align: center; /* Center align the logo and "Log in" text */
        width: 100%;
    }

    .logo {
        font-family: 'Arial', sans-serif;
        font-size: 30px;
        font-weight: bolder;
        color: #000;
        margin-bottom: 40px; /* Increased space below logo */
    }

    .log-in-text {
        font-weight: normal; /* Make "Log in" text bolder */
        font-size: 22px;
        margin-bottom: 30px; /* Increased space below "Log in" */
    }

    .form-control, .btn-custom {
        background-color: #ffffff;
        border: 2px solid #cc0000;
        border-radius: 5px;
        color: #000;
        padding: 15px;
        width: 100%; /* Full width of parent, accounting for padding */
        box-sizing: border-box; /* Include padding and border in the element's total width */
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .btn-custom {
        background-color: #cc0000;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .footer-links {
        margin-top: auto;
        font-size: 14px;
        text-align: center; /* Center the footer links */
    }

    .footer-links a {
        color: #000;
        text-decoration: none;
        margin: 0 10px; /* Keeps spacing between links */
    }

    /* Loader CSS */
    #loader-wrapper {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent white background */
        z-index: 9999;
        top: 0;
        left: 0;
        display: none; /* Initially hide loader */
        align-items: center;
        justify-content: center;
    }

    #loader {
        border: 16px solid #f3f3f3; /* Light grey border */
        border-top: 16px solid #3498db; /* Blue border on top */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite; /* Rotation animation */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<!-- Loader HTML -->
<div id="loader-wrapper">
    <div id="loader"></div>
</div>

<!-- Before your login form -->
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- Your login form continues below -->

<div class="login-box">
    <div class="logo">PowerGym</div>
    <div class="log-in-text">Log in</div>
    <form action="{{route('login.post')}}" method="POST">
        @csrf
        <div>
            <input type="email" class="form-control" name="email" placeholder="Email address">
        </div>

        <div>
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>

        <button type="submit" class="btn-custom">Login</button>
        <div class="footer-links">
    <a href="{{ route('membership.store') }}">Fill form</a> | <a href="{{ route('privacy-policy') }}">Privacy</a> | <a href="{{ route('terms-of-use') }}">Terms of Use</a> | <a href="{{ route('password.request') }}">Forgot Password?</a>
</div>

    </form>
   
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">

function showLoader() {
        document.getElementById("loader-wrapper").style.display = "flex";
    }

    function hideLoader() {
        document.getElementById("loader-wrapper").style.display = "none";
    }

    // Intercept form submission to show loader
    document.getElementById("login-form").addEventListener("submit", function () {
        showLoader();
    });
</script>
  </body>
</html>
@endsection
