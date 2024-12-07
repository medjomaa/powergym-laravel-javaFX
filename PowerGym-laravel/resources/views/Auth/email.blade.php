@extends('frontend')

@section('title', 'Forgot Password')

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
    <div class="log-in-text">Forgot Password</div>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <input type="email" class="form-control" name="email" placeholder="Email address" value="{{ old('email') }}">
        </div>
        <div>
            <input type="text" class="form-control" name="phone" placeholder="Phone number" value="{{ old('phone') }}">
        </div>
        <div>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn-custom">Submit</button>
    </form>
</div>
@endsection
