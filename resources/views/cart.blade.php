@extends('master')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/style/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/form.css') }}">

    <style>
        .shopping-cart-container .list-container {
            margin-top: 2rem;
        }

        .shopping-cart-container .list-container .item {
            display: flex;
            gap: 2rem;
            align-content: center;
            margin-bottom: 1rem;
        }

        .shopping-cart-container .list-container .item .item-info {
            width: 90%;
        }

        .shopping-cart-container .list-container .item .remove-btn {
            display: inline;
            width: auto;
            height: auto;
            margin-left: auto;
            border: 0;
            background-color: transparent;
            font-size: 1.5rem;
            color: var(--text-pale-color);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .shopping-cart-container .list-container .item .remove-btn:hover {
            color: var(--primary-color);
        }

        .shopping-cart-container .list-container .item .item-info {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .shopping-cart-container .list-container .item .item-info img {
            width: 150px;
            margin-right: 1rem;
        }


        .shopping-cart-container .list-container .item .item-info span {
            display: block;
        }

        .shopping-cart-container .list-container .item .item-info .item-name {
            width: 100%;
            font-size: 1.2rem;
        }

        .shopping-cart-container .list-container .item .item-info .price {
            width: 100%;
            margin-top: 1rem;
            font-size: .9rem;
        }

        /* Checkout container */
        .checkout-container {
            width: 40%;
            margin-left: auto;
        }

        .checkout-container .sub-total {
            font-size: 1.5rem;
            margin: 1.2rem 0;
        }

        @media screen and (max-width: 720px) {
            .shopping-cart-container .list-container .item .item-info img {
                width: 100px;
                height: auto;
            }

            .shopping-cart-container .list-container .item .item-info .item-name {
                width: 100%;
                font-size: 1.2rem;
            }

            .shopping-cart-container .list-container .item .item-info .price {
                font-size: .8rem;
            }

            .checkout-container {
                width: 60%;
            }
        }

        @media screen and (max-width: 480px) {
            .shopping-cart-container .list-container .item .remove-btn {
                font-size: 1rem;
            }

            .shopping-cart-container .list-container .item .item-info img {
                width: 80px;
                height: auto;
                margin-right: 0;
            }

            .shopping-cart-container .list-container .item .item-info .item-name {
                font-size: 1rem;
            }

            .shopping-cart-container .list-container .item .item-info .price {
                font-size: .75rem;
            }

            .checkout-container {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    @include('nav');

    <section>
        <div class="shopping-cart-container" style="margin-top: 6rem">
            <h1 style="text-decoration: underline">Shopping Cart</h1>
            <div class="list-container" id="listContainer" style="border-bottom: 1px solid var(--pale-stroke)">
                @if (count($cart) > 0)
                    @foreach ($cart as $c)
                        <div class="item animate__animated animate__fadeIn">
                            <div class="item-info">
                                <img src="{{ asset('assets/vendor/images/pdf.jpg') }}" alt="">
                                <div class="content-container">
                                    <span class="item-name">{{ $c->product->name }}</span>
                                    <span class="price">$ {{ $c->price }}</span>
                                </div>
                            </div>
                            <button class="remove-btn" id="removeCartBtn" data-slug="{{ $c->product->slug }}">X</button>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex flex-column gap-2 align-item-start">
                        <h3 class="placeholder" style="text-align: left;">There is no item inside cart.</h3>
                        <a href="/" class="fill_btn"
                            style="text-align: center; display: flex; justify-content: center; align-items: center; text-decoration: none; padding: .5rem 1rem; font-size: 15px">Go
                            shopping</a>
                    </div>
                @endif
            </div>
            <div class="checkout-container">
                <div class="sub-total d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span id="subTotal">$ {{ $subTotal }}</span>
                </div>
                <button class="fill_btn w-100" style="padding: 1rem 0;" onclick="checkout()">Checkout</button>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('/assets/script/removeCart.js') }}"></script>
    <script src="{{ asset('/assets/script/checkout.js') }}"></script>
@endsection
