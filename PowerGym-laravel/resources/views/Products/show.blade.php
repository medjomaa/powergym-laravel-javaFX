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

    .popup-container {
        width: 80%;
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
    }

    .product-card {
        flex: 1;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }

    .product-image {
        max-width: 100%;
        max-height: 200px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .product-details {
        color: #fff;
    }

    .product-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #f8b400;
        font-family: 'Georgia', serif;
        text-align: center;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .product-description {
        font-size: 16px;
        margin-bottom: 10px;
        color: rgba(255, 255, 255, 0.8);
        font-family: 'Verdana', sans-serif;
        text-align: justify;
        line-height: 1.5;
    }

    .product-price {
        font-size: 16px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.6);
        font-family: 'Courier New', monospace;
    }

    .action-button {
        background-color: rgba(0, 0, 0, 0.5);
        color: rgba(255, 0, 0, 0.7);
        font-size: 14px;
        border: 2px solid rgba(255, 0, 0, 0.7);
        border-radius: 5px;
        padding: 5px 10px;
        transition: all 0.3s ease;
    }

    .action-button:hover {
        background-color: rgba(255, 0, 0, 0.7);
        color: #fff;
    }
</style>

<div class="popup-container">
    <div class="product-card">
        @if($product->image)
            <img src="{{ asset($product->image) }}" alt="Product Image" class="product-image">
        @else
            No Image
        @endif
        <div class="product-details">
            <div class="product-title">{{ $product->name }}</div>
            <div class="product-description">{{ $product->description }}</div>
            <div class="product-price">Price: ${{ $product->price }}</div>
        </div>
    </div>
    <div>
        <!-- Additional content or small product card can be added here -->
    </div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    // Open modal and load product details
    $('.view-product').click(function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        $.get('/products/' + productId, function(data) {
            $('.modal-content').html(data);
            $('#productModal').fadeIn();
        });
    });

    // Close modal when clicking outside
    $(document).mouseup(function(e) {
        var container = $(".modal-content");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('#productModal').fadeOut();
        }
    });
});
</script>

@endsection
