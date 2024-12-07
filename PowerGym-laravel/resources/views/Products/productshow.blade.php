@extends('frontend')
@section('title', 'Power Gym - Boutique')
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
            color: rgb(192, 192, 192);
            font-family: Cambria;
            font-size: 16px;
            background-image: url('https://images.hdqwalls.com/download/3d-abstract-traingle-low-poly-rq-1920x1200.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .welcome {
            margin: 20px auto;
            width: 70%;
            border: 2px solid #ffffff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.7);
            color: #e0e0e0;
        }

        .welcome p {
            color: #f8f8f8;
        }

        .search {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .content-section {
            text-align: justify;
            padding: 0 20px;
            margin-top: 20px;
            color: #ffffff;
            font-size: 18px;
        }

        .welcome h2 {
            color: #ffffff;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .product p {
            margin: 10px 0;
            color: #ffffff;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .product {
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
            min-height: 400px;
        }

        .product h2 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
        }

        .product p {
            margin: 10px 0;
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .button-container {
            display: flex;
            gap: 10px;
            width: 100%;
        }

        .buy-button,
        .add-to-cart-button {
            flex: 1;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #cc0000;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .buy-button:hover,
        .add-to-cart-button:hover {
            background-color: #ff4d4d;
        }

        .search input[type="text"],
        .search select {
            width: 200px;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #ffffff;
            background-color: rgba(255, 255, 255, 0.5);
            color: #000000;
        }

        .search button {
            width: auto;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #cc0000;
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            align-self: center;
        }

        .search button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
<div class="welcome">
    <h2>Welcome to Power Gym Boutique</h2>
    <p>Explore our top-quality training equipment and gear up for your fitness journey!</p>
    <p>At Power Gym Boutique, we are committed to providing you with the best fitness gear and equipment to support your wellness journey. Our carefully selected products range from professional gym machines to comfortable athletic wear, ensuring that you have everything you need for effective workouts. Explore our collection and find the perfect fit for your fitness goals!</p>

    <div class="search">
        <form action="{{ route('products.productshow') }}" method="GET">
        <input type="text" id="search-input" name="search" placeholder="Search products..." value="{{ request('search') }}">
            <select name="sort">
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Price low to high</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Price high to low</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
            </select>
            <button type="submit" class="buy-button">Update</button>
        </form>
    </div>
</div>

<!-- Product Show Page -->

<!-- Existing content -->
<div class="products-container">
    @foreach($products as $product)
    <div class="product">
        <img src="{{ $product->image }}" alt="{{ $product->name }}">
        <h2>{{ $product->name }}</h2>
        <p>{{ $product->description }}</p>
        <p>Price: ${{ $product->price }}</p>
        @if($product->stock > 0)
        <div class="button-container">
            <form id="purchase-form-{{ $product->id }}" action="{{ route('purchase', ['id' => $product->id]) }}"
            method="POST">
                @csrf
                <button type="button" class="buy-button" onclick="confirmPurchase({{ $product->id }})">Buy</button>
            </form>
            <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="button" class="add-to-cart-button" onclick="confirmAddToCart({{ $product->id }})">Add to Cart</button>
            </form>
        </div>
        @else
        <p style="color: red;">Out of Stock</p>
        @endif
    </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
   function confirmAddToCart(productId) {
        Swal.fire({
            title: 'Add to Cart',
            text: 'Are you sure you want to add this product to the cart?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!'
        }).then((result) => {
            if (result.isConfirmed) {
                addToCart(productId);
            }
        });
    }

    function addToCart(productId) {
        var formData = $('#add-to-cart-form-' + productId).serialize();
        $.ajax({
            url: $('#add-to-cart-form-' + productId).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Added to Cart!',
                    text: 'Product added to cart successfully.',
                    icon: 'success'
                });
            },
            error: function(xhr, status, error) {
                console.error('Error adding product to cart:', error);
            }
        });
    }
    function updateProducts() {
        // Serialize form data
        var formData = $('#product-search-form').serialize();

        // Send AJAX request to fetch products based on search and sort
        $.ajax({
            url: $('#product-search-form').attr('action'),
            method: 'GET',
            data: formData,
            success: function(response) {
                // Update the product list with the fetched products
                $('.products-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
    }

    function confirmPurchase(productId) {
        Swal.fire({
            title: 'Confirm Purchase',
            text: 'Are you sure you want to purchase this product?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, purchase it!'
        }).then((result) => {
            if (result.isConfirmed) {
                purchaseProduct(productId);
            }
        });
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
</body>
</html>

@endsection
