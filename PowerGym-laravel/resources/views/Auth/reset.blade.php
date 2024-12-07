@extends('frontend')
@section('title','Reset Password')
@section('content')
<style>
  

.logo {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.log-in-text {
    color: wheat;
    text-align: center;
    font-size: 18px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-control {
    width: 100%;
    height: 40px;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.btn-custom {
    width: 100%;
    height: 40px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-custom:hover {
    background-color: #0056b3;
}

    </style>
<div class="login-box">
    <div class="logo">PowerGym</div>
    <div class="log-in-text">Reset Password</div>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <div>
            <input type="password" class="form-control" name="password" placeholder="New password">
        </div>
        <div>
            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
        </div>
        <button type="submit" class="btn-custom">Reset Password</button>
    </form>
</div>
@endsection
