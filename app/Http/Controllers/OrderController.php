<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CompanyDetail;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Support\Str;
use Stripe\Customer;

class OrderController extends Controller
{
    public function getCartData()
    {
        $cartToken = Cookie::get('cartToken');

        $cart = Cart::where('cartToken', $cartToken)->get();

        return $cart;
    }
    public function getCartSubTotal($cart)
    {
        $subTotal = 0;

        if (count($cart) > 0) {
            foreach ($cart as $c) {
                $subTotal += $c->price;
            }
        }

        return $subTotal;
    }
    public function getCartTotal($cart)
    {
        $subTotal = $this->getCartSubTotal($cart);
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


    public function showCheckout(Request $request)
    {
        $company = CompanyDetail::find(1);

        $cartToken = Cookie::get('cartToken');
        $cart = Cart::where('cartToken', $cartToken)->get();

        if ($cartToken) {
            $cartData = Cart::where('cartToken', $request->cartToken)->get();

            if (count($cartData) > 0) {
                $cartCount = $this->getCartCount();

                $subTotal = $this->getCartSubTotal($cart);
                $total = $this->getCartTotal($cart);

                return view('checkout', compact('cartCount', 'cartData', 'company', 'subTotal', 'total', 'cartToken'));
            } else {
                return redirect('/');
            }
        }
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $email = $request->email;
        $userInfo = json_decode($request->paymentInfo);
        $token = $request->stripeToken;

        $cartToken = Cookie::get('cartToken');
        $cart = Cart::where('cartToken', $cartToken)->get();

        try {
            $charge = Charge::create([
                'amount' => $request->total * 100,
                'currency' => 'usd',
                'source' => $token
            ]);

            $order = Order::create([
                'cartToken' => $cartToken,
                'fname' => $userInfo->fName,
                'lname' => $userInfo->lName,
                'email' => $email,
                'address' => $userInfo->address,
                'country' => $userInfo->country,
                'postal_code' => $userInfo->postalCode,
                'city' => $userInfo->city,
                'state' => $userInfo->state,
                'phone_number' => $userInfo->phoneNumber,
                'order_confirmed_time' => Carbon::now()->format('h:i:s'),
                'order_confirmed_date' => Carbon::now()->format('Y-m-d'),
                'order_confirm' => 'confirmed',
                'sub_total' => $request->subTotal,
                'tax' => $request->tax,
                'total' => $request->total
            ]);

            Payment::create([
                'order_id' => $order->id,
                'name' => $userInfo->fName . ' ' . $userInfo->lName,
                'transaction_id' => $charge->id,
                'status' => Charge::retrieve($charge->id, Stripe::setApiKey(env('STRIPE_SECRET')))->status,
                'card_last_four' => $charge->payment_method_details->card->last4,
                'card_brand' => $charge->payment_method_details->card->brand,
                'currency' => 'usd',
                'total' => $request->total,
                'giving_date' => Carbon::now()->format('d-m-Y')
            ]);

            foreach ($cart as $c) {
                ProductOrder::create([
                    'order_id' => $order->id,
                    'product_id' => $c->product->id
                ]);

                $c->delete();
            }

            return redirect('/receipt?cartToken=' . $cartToken)->with('success', 'Checkout successfully.');
        } catch (\Stripe\Exception\CardException $e) {
            // Payment failed message to user with reason
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getError()->message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getError()->message);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getError()->message);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            Log::error('Stripe Payment Error: ' . $e->getMessage());
            return redirect()->back();
            // return redirect()->back()->with('error', 'Payment failed: ' . $e->getError()->message);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getError()->message);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getError()->message);
        }
    }

    public function getCartToken()
    {
        $cartToken = Cookie::get('cartToken');
        if ($cartToken) {
            return response()->json([
                'status' => 202,
                'stage' => 'success',
                'message' => 'Got cart token. Redirect to checkout.',
                'data' => $cartToken
            ]);
        }

        return response()->json([
            'status' => 404,
            'stage' => 'failed',
            'message' => 'Session expired. Please add to cart again.'
        ], 404);
    }

    public function showReceipt(Request $request)
    {
        $cartToken = $request->cartToken;
        if (Cookie::get('cartToken') !== $cartToken) {
            abort(404);
        }

        $order = Order::where('cartToken', $cartToken)->with('product')->first();

        return view('receipt', compact('order', 'cartToken'));
    }

    public function download($cartToken, $filename)
    {
        $order = Order::where('cartToken', $cartToken)->first();

        if ($order && $order->order_confirm === 'confirmed') {
            $file = storage_path("app/pdfs/{$filename}");

            if (file_exists($file)) {
                return response()->file($file, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                ]);
            } else {
                return response()->json(['error' => 'File not found.'], 404);
            }

            // If no matching PDF file was found, return an error response
            return response()->json(['error' => 'PDF file not found for this order.'], 404);
        }

        // If the conditions are not met, return an error response
        return response()->json(['error' => 'Invalid request.'], 400);
    }
}
