<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CompanyDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Stripe\Stripe;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function generateUniqueId()
    {
        // Generate a unique identifier, for example, using Laravel's Str::uuid() method.
        return Str::random(32);
    }
    public function getCartData()
    {
        $cartToken = Cookie::get('cartToken');

        $cart = Cart::where('cartToken', $cartToken)->get();

        return $cart;
    }
    public function getCartSubTotal()
    {
        $cart = $this->getCartData();

        $subTotal = 0;

        if (count($cart) > 0) {
            foreach ($cart as $c) {
                $subTotal += $c->price;
            }
        }

        return $subTotal;
    }
    public function getCartTotal()
    {
        $subTotal = $this->getCartSubTotal();
        $tax = CompanyDetail::where('id', 1)->first()->tax;

        $total = 0;
        $total = $subTotal + $tax;
        return $total;
    }
    public function getCartCount()
    {
        $cart = $this->getCartData();

        $cartCount = 0;
        if (count($cart) > 0) {
            $cartCount = count($cart);
        }

        return $cartCount;
    }

    public function addToCart(Request $request)
    {
        // Initialize Stripe with your API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $cartToken = Cookie::get('cartToken');
        // $cartToken = session()->get('cartToken');

        if (!$cartToken) {
            $cartToken = $this->generateUniqueId(); // Generate a unique identifier.

            // Define the number of minutes you want the cookie to persist.
            $minutes = 60 * 24 * 3; // 7 days

            Cookie::queue('cartToken', $cartToken, $minutes);
        }

        // Retrieve product slug from the request
        $productSlug = $request->slug;

        $product = Product::where('slug', $productSlug)->first();
        $cart = Cart::where('cartToken', $cartToken)->get();

        // Check if the product exists in the cart by comparing 'id' values.
        $productExistsInCart = $cart->contains('product_id', $product->id);

        if (!$productExistsInCart) {
            Cart::create([
                'product_id' => $product->id,
                'cartToken' => $cartToken,
                'price' => $product->price
            ]);
        }

        $allCartForThisUser = Cart::where('cartToken', $cartToken)->get();

        // Respond with a success message or updated cart data
        return response()->json([
            'status' => 200,
            'stage' => 'success',
            'message' => 'Product added to cart',
            'data' => $allCartForThisUser,
            'count' => count($allCartForThisUser),
            'cartToken' => $cartToken
        ]);
    }

    public function removeCart(Request $request)
    {
        $company = CompanyDetail::find(1);

        $cartToken = Cookie::get('cartToken');
        if (!$cartToken) {
            return response()->json([
                'status' => 404,
                'stage' => 'failed',
                'message' => "Session expired."
            ], 440);
        }

        $removedProduct = Product::where('slug', $request->slug)->first();
        $removedCartItem = Cart::where('cartToken', $cartToken)->where('product_id', $removedProduct->id)->first();

        if (!$removedCartItem) {
            return response()->json([
                'status' => 404,
                'stage' => 'failed',
                'message' => 'Cart not found. Please try again or contact us.',
            ], 404);
        }

        $removedCartItem->delete(); // Delete cart item from database

        $cart = $this->getCartData();
        $cartCount = $this->getCartCount();
        $subTotal = $this->getCartSubTotal();
        $total = $this->getCartTotal();

        return response()->json([
            'status' => 202,
            'stage' => 'success',
            'message' => 'Cart has been removed',
            'cartCount' => $cartCount,
            'subTotal' => $subTotal,
            'tax' => $company->tax,
            'total' => $total
        ]);
    }
}
