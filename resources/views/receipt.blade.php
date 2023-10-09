@extends('master')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/style/receipt.css') }}">
@endsection

@section('content')
    <section class="receipt-container">
        <div class="header-container">
            <h2>Receipt</h2>
            <a href="{{ url('/') }}"><i class="fa-solid fa-arrow-up-right-from-square"></i> Continue shopping</a>
        </div>
        <div class="information-container">
            <div class="left order-container">
                <h3 class="header">Order</h3>
                <div class="cart-container">
                    <div class="product-container">
                        @foreach ($order->product as $p)
                            <div class="item">
                                <img src="{{ $p->img_url }}" alt="">
                                <div class="itemInfo-container">
                                    <div class="top">
                                        <span class="name">{{ $p->name }}</span>
                                        <span class="price">$ {{ $p->price }}</span>
                                    </div>
                                    <div class="bottom">
                                        <button class="download-btn" data-slug="{{ $p->slug }}"><i
                                                class="fas fa-download"></i> Download Item</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="subTotal-container">
                        <div class="cost-container">
                            <span>Subtotal</span>
                            <span id="subTotal">$ {{ $order->sub_total }}</span>
                        </div>
                        <div class="cost-container">
                            <span>Tax</span>
                            <span id="tax">$ {{ $order->tax }}</span>
                        </div>
                    </div>
                    <div class="total-container cost-container">
                        <span>Total</span>
                        <span id="total">$ {{ $order->total }}</span>
                    </div>
                </div>
            </div>
            <div class="right userInfo-container">
                <h3 class="header">Customer</h3>
                <div class="info-container">
                    <span class="sm-header">Contact</span>
                    <div class="user-container">
                        <span class="name">{{ $order->fname . ' ' . $order->lname }}</span>
                        <span class="email">{{ $order->email }}</span>
                        <span class="phone">{{ $order->phone_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const cartToken = '{!! $cartToken !!}';
    </script>

    <script src="{{ asset('/assets/script/download.js') }}"></script>
@endsection
