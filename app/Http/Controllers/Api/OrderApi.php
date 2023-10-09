<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderApi extends Controller
{
    public function addToCart(Request $request)
    {
        // Retrieve cart data from the request (e.g., product ID and quantity)
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Store cart data in the session
        $cart = session('cart', []);
        $cart[$productId] = $quantity;
        session(['cart' => $cart]);

        // Respond with a success message or updated cart data
        return response()->json(['message' => 'Cart updated successfully', 'cart' => $cart]);
    }
}
