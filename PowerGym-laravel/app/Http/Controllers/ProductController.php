<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user->email == 'admin@gmail.com') {
                return $next($request);
            } else {
                return redirect('/products')->with('error', 'Only admins can create, edit, or delete products.');
            }
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    
    public function details($id)
    {
        $product = Product::findOrFail($id);
        return view('products.details', compact('product'));
    }
    
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
    
    public function productshow(Request $request)
    {
        $query = Product::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        switch ($request->input('sort')) {
            case 'asc':
                $query->orderBy('price', 'asc');
                break;
            case 'desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }
        $products = $query->get();
        return view('products.productshow', compact('products'));
    }
    
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image_file')) {
            $fileName = time() . '.' . $request->image_file->extension();
            $request->image_file->move(public_path('uploads'), $fileName);
            $imagePath = url('uploads/' . $fileName);
        } else {
            $imagePath = $request->image;
        }

        $validatedData['image'] = $imagePath;

        Product::create($validatedData);

        return redirect(route('products.index'))->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
    
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image_file')) {
            $fileName = time() . '.' . $request->image_file->extension();
            $request->image_file->move(public_path('uploads'), $fileName);
            $validatedData['image'] = url('uploads/' . $fileName);
        } elseif ($request->input('image')) {
            $validatedData['image'] = $request->image;
        } else {
            $validatedData['image'] = $product->image;
        }

        $product->update($validatedData);

        return redirect(route('products.index'))->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(route('products.index'))->with('success', 'Product deleted successfully.');
    }

    public function purchase($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock > 0) {
            $product->stock -= 1;
            $product->save();

            // Optionally, you can add logic here to handle purchase records, notifications, etc.

            return redirect()->route('products.index')->with('success', 'Product purchased successfully!');
        }

        return redirect()->route('products.index')->with('error', 'Product is out of stock.');
    }


public function purchase2($id, Request $request)
{
    $product = Product::findOrFail($id);

    // Check if the product exists in the cart
    $cartItem = Cart::where('product_id', $id)->first();

    if ($cartItem) {
        $quantityPurchased = $cartItem->quantity;

        // Check if the quantity purchased exceeds the available stock
        if ($quantityPurchased > $product->stock) {
            return redirect()->route('cart.show')->with('error', 'The quantity purchased exceeds the available stock.');
        }

        // Decrease the stock quantity by the purchased quantity
        $product->stock -= $quantityPurchased;
        $product->save();

        // Delete the cart item
        $cartItem->delete();
    }

    // Perform any additional actions related to the purchase

    return redirect()->route('cart.show')->with('success', 'Product(s) purchased successfully!');
}


    
}
