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

    .cards-container {
        display: flex;
        flex-wrap: wrap;
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
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 10px;
    }

    .card-actions .btn {
        background-color: rgba(0, 0, 0, 0.5);
        color: rgba(255, 0, 0, 0.7);
        font-size: 14px;
        border: 2px solid rgba(255, 0, 0, 0.7);
        border-radius: 5px;
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
@if (Auth::user()->isAdmin())
<div class="table-title">
    <h2>Manage <b>Products</b></h2>
    <a href="{{ route('products.create') }}" class="btn btn-success">
        <i class="fas fa-plus icon"></i> <span>Create New Product</span>
    </a>
</div>
@endif

<div class="cards-container">
    @foreach ($products as $product)
        <div class="card">
            <div class="card-title">{{ $product->name }}</div>
            <div class="card-description">{{ $product->description }}</div>
            <div class="card-price">Price: ${{ $product->price }}</div>
            @if($product->image)
                <img src="{{ asset($product->image) }}" alt="Product Image" class="product-image">
            @else
                No Image
            @endif
            
            <div class="card-actions">
                <a href="#" class="btn btn-primary view-product" data-product-id="{{ $product->id }}">
                    <i class="fas fa-eye"></i> View
                </a>
                @if($product->stock > 0)
                <form id="purchase-form-{{ $product->id }}" action="{{ route('purchase', ['id' => $product->id]) }}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-danger" onclick="confirmPurchase({{ $product->id }})">Buy</button>
                </form>
        
                <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="button" class="btn btn-danger" onclick="confirmAddToCart({{ $product->id }})">Add to Cart</button>
                </form>
                @else
                <p style="color: red;">Out of Stock</p>
                @endif
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="confirmDeletion(event)" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>
                @endif
            </div>
           
        </div>
    @endforeach
</div>

<div id="productModal" class="modal" style="display:none;">
    <div class="modal-content">
        <!-- Product details will be loaded here -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function confirmDeletion(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit();
            }
        });
    }

    function confirmPurchase(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to proceed with the purchase?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, buy it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('purchase-form-' + productId).submit();
            }
        });
    }

    function confirmAddToCart(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to add this item to the cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('add-to-cart-form-' + productId).submit();
            }
        });
    }

    $(document).ready(function() {
        $('.view-product').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            $.ajax({
                url: '/products/' + productId,
                type: 'GET',
                success: function(response) {
                    $('#productModal .modal-content').html(response);
                    $('#productModal').show();
                }
            });
        });

        $(document).click(function(event) {
            if ($(event.target).closest('.modal-content').length === 0) {
                $('#productModal').hide();
            }
        });
    });
</script>

@endsection