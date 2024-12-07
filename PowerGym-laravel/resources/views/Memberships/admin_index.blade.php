@extends('dashboard')

@section('title', 'Admin - Memberships')

@section('content')
<style>
    body {
        background-image: url("https://files.123freevectors.com/wp-content/original/128899-glowing-red-and-blue-wave-background.jpg");
        background-size: cover; /* Scale the background to be as large as possible */
        background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Do not repeat the background */
        background-attachment: fixed;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        color: #E0E0E0;
    }

    .container {
        background-color: rgba(45, 85, 255, 0.2);
        padding: 20px;
        border-radius: 8px;
        width: 110%;
        max-width: 1200px;
        margin-top: 50px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    h2 {
        text-align: center;
        color: rgba(72, 113, 247);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #cc0000;
        color: white;
    }

    td {
        background-color: rgba(45, 85, 255, 0.2);
        color: #E0E0E0;
    }

    .btn-success {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-success:hover {
        background-color: #45a049;
    }

    /* Additional CSS for form elements */
    .form-control {
        border-radius: 4px;
        padding: 8px;
        border: 1px solid #ccc;
        width: 100%;
    }

    .btn-primary {
        border-radius: 4px;
        padding: 8px 16px;
        background-color: #007bff;
        border: none;
        color: white;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .row {
        margin-bottom: 10px;
    }
</style>

<div class="container mt-5">
    <h2>Membership Submissions</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.memberships.index') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="sort_by" class="form-control">
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                    <option value="paid" {{ request('sort_by') == 'paid' ? 'selected' : '' }}>Sort by Paid Status</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort_order" class="form-control">
                    <option value="asc" {{ request('sort_order', 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">Apply</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <!-- Table header remains the same -->
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Membership Type</th>
                <th>Paid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($memberships as $membership)
                <tr>
                    <td>{{ $membership->name }}</td>
                    <td>{{ $membership->email }}</td>
                    <td>{{ $membership->phone }}</td>
                    <td>{{ ucfirst($membership->membership_type) }}</td>
                    <td>{{ $membership->paid ? 'Yes' : 'No' }}</td>
                    <td>
                        <form action="{{ route('admin.memberships.approve', $membership->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
