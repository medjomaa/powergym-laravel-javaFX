@extends('dashboard')

@section('content')
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
        background-image: url("https://images.hdqwalls.com/download/3d-abstract-traingle-low-poly-rq-1920x1200.jpg");
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
        width: 100%;
        padding: 20px;
        background: linear-gradient(45deg, #8B0000, #00008B);
        color: #fff;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .table-title h2 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    .cards-container {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        gap: 20px;
    }

    .card {
        background-color: rgba(0, 0, 0, 0.5);
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

    .card-price {
        font-size: 16px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.6);
        font-family: 'Courier New', monospace;
    }

    .product-image {
        max-width: 100%;
        max-height: 150px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn {
        background-color: #8B0000;
        color: #fff;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #00008B;
    }

    .btn-primary {
        background-color: #00008B;
        border-color: #00008B;
    }

    .btn-danger {
        background-color: #8B0000;
        border-color: #8B0000;
    }

    .buy-button {
        background-color: #008CBA;
        border-color: #008CBA;
    }

    .buy-button:hover {
        background-color: #005f6b;
    }

    .single-item-card {
        width: 100%;
        margin-bottom: 20px;
    }

    .button-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }

    .button-group form {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .button-group input[type="number"] {
        width: 60px;
        margin-right: 10px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <div class="table-title">
        <h2>Your Cart</h2>
    </div>
    @if ($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @elseif ($cartItems->count() === 1)
        <div class="single-item-card card">
            @foreach ($cartItems as $cartItem)
                <div class="card-title">{{ $cartItem->product->name }}</div>
                <div class="card-description">{{ $cartItem->product->description }}</div>
                <div class="card-price">Price: ${{ $cartItem->product->price }}</div>
                <img src="{{ $cartItem->product->image }}" alt="Product Image" class="product-image">
                <div class="card-actions button-group">
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cartItem->id }}">
                        <input type="number" name="quantity" value="{{ $cartItem->quantity }}">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cartItem->id }}">
                        <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                    <form id="purchase-form-{{ $cartItem->product->id }}" action="{{ route('purchase2', ['id' => $cartItem->product->id]) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="{{ $cartItem->quantity }}">
                        <button type="button" class="btn buy-button" onclick="confirmPurchase({{ $cartItem->product->id }})">Buy</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="cards-container">
            @foreach ($cartItems as $cartItem)
                <div class="card">
                    <div class="card-title">{{ $cartItem->product->name }}</div>
                    <div class="card-description">{{ $cartItem->product->description }}</div>
                    <div class="card-price">Price: ${{ $cartItem->product->price }}</div>
                    <img src="{{ $cartItem->product->image }}" alt="Product Image" class="product-image">
                    <div class="card-actions button-group">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $cartItem->id }}">
                            <input type="number" name="quantity" value="{{ $cartItem->quantity }}">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $cartItem->id }}">
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                        <form id="purchase-form-{{ $cartItem->product->id }}" action="{{ route('purchase2', ['id' => $cartItem->product->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $cartItem->quantity }}">
                            <button type="button" class="btn buy-button" onclick="confirmPurchase({{ $cartItem->product->id }})">Buy</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script>
    function confirmPurchase(productId) {
        if (confirm('Are you sure you want to buy this item?')) {
            document.getElementById('purchase-form-' + productId).submit();
        }
    }
    function purchaseProduct(productId) {
        var formData = $('#purchase-form-' + productId).serialize();
        $.ajax({
            url: $('#purchase-form-' + productId).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Purchase Successful!',
                    text: 'Thank you for your purchase.',
                    icon: 'success'
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr, status, error) {
                console.error('Error purchasing product:', error);
            }
        });
    }
</script>
@endsection
