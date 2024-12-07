<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $userId = auth()->id();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
    
        // Check if the item already exists in the cart for the user
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();
    
        if ($cartItem) {
            // Update the quantity
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Create a new entry in the cart table
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
    
        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }


    public function showCart()
    {
        $userId = auth()->id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();
    
        return view('cart.show', compact('cartItems'));
    }
    
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $cartId = $request->input('cart_id');
        $quantity = $request->input('quantity');
    
        $cartItem = Cart::findOrFail($cartId);
        $cartItem->quantity = $quantity;
        $cartItem->save();
    
        return redirect()->back()->with('success', 'Cart updated successfully.');
    }
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);
    
        $cartId = $request->input('cart_id');
    
        $cartItem = Cart::findOrFail($cartId);
        $cartItem->delete();
    
        return redirect()->back()->with('success', 'Item removed from cart successfully.');
    }
                
}
