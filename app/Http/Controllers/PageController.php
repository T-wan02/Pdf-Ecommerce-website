<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CompanyDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class PageController extends Controller
{
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


    public function home()
    {
        $products = Product::all();

        $cartCount = $this->getCartCount();

        return view('index', compact('products', 'cartCount'));
    }

    public function showCart()
    {
        $company = CompanyDetail::find(1);

        $cart = $this->getCartData();
        $cartCount = $this->getCartCount();

        $subTotal = $this->getCartSubTotal();
        $tax = $company->tax;
        $total = $this->getCartTotal();

        return view('cart', compact('cartCount', 'cart', 'company', 'subTotal', 'tax', 'total'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $cartCount = $this->getCartCount();

        return view('product-detail', compact('product', 'cartCount'));
    }
}
