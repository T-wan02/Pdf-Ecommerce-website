@extends('master')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/style/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/form.css') }}">

    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    @include('subNav');

    <section class="cart-container d-flex gap-1">
        <div class="left information-container d-flex flex-column gap-2">
            <div class="email information active" data-type="email">
                <div class="process-container">
                    <div class="circle">1</div>
                    <div class="process"></div>
                </div>
                <form class="email-form form-container" action="#" data-type="email">
                    <div class="header-container">
                        <h2 class="form-header">Enter Email</h2>
                        <a href="#" class="edit-form-btn" data-type="email">edit</a>
                    </div>
                    <div class="form-input-container">
                        <input type="email" placeholder="example@gmail.com" class="email form-control" id="email_header"
                            name="email" required>
                        <input type="submit" class="fill_btn w-100" value="Submit">
                    </div>
                    <div class="form-data-disabled">
                    </div>
                </form>
            </div>
            <div class="payment information no_data" data-type="payment">
                <div class="process-container">
                    <div class="circle">2</div>
                    <div class="process"></div>
                </div>
                <form action="#" class="payment-form form-container" id="payment-form" data-type="payment">
                    <div class="header-container">
                        <h2 class="form-header">Payment</h2>
                        <a href="#" class="edit-form-btn" data-type="payment">edit</a>
                    </div>
                    <div class="form-input-container">
                        <div id="card-errors" role="alert"></div>
                        <div class="form-group" style="margin-bottom: 1rem">
                            <div id="card-element" class="form-control"></div>
                        </div>
                        <header>Billing Address</header>
                        <div class="form-group d-flex gap-1 gap-md-1 row-md-col">
                            <input type="text" class="form-control" placeholder="First Name" name="fName" required>
                            <input type="text" class="form-control" placeholder="Last Name" name="lName" required>
                        </div>
                        <input type="text" class="form-control w-100" placeholder="Address" name="address" required>
                        <select name="country" id="countriesSelect" class="form-control w-100" style="display: block;">
                            <option value="testOne">Test One</option>
                            <option value="testTwo">Test Two</option>
                            <option value="testThree">Test Three</option>
                        </select>
                        <div class="form-group d-flex gap-md-1 row-md-col">
                            <input type="number" class="form-control" placeholder="Postal Code" name="postalCode" required>
                            <input type="text" class="form-control" placeholder="City" name="city" required>
                            <input type="text" class="form-control" placeholder="State" name="state" required>
                        </div>
                        <input type="text" class="form-control" placeholder="Phone number" name="phoneNumber" required>
                        {{-- <input type="submit" class="fill_btn w-100" value="Submit"> --}}
                        <button type="submit" class="fill_btn w-100">Submit</button>
                    </div>
                    <div class="form-data-disabled">

                    </div>
                </form>
            </div>
            <div class="confirm information no_data" data-type="confirmation">
                <div class="process-container">
                    <div class="circle">3</div>
                </div>
                <form action="{{ url('/checkout?cartToken=' . $cartToken) }}" method="POST"
                    class="confirm-form form-container" id="confirmForm">
                    @csrf
                    <input type="hidden" name="email" id="emailInfo">
                    <input type="hidden" name="paymentInfo" id="paymentInfo">
                    <input type="hidden" name="subTotal" value="{{ $subTotal }}">
                    <input type="hidden" name="tax" value="{{ $company->tax }}">
                    <input type="hidden" name="total" value="{{ $total }}">
                    <div class="header-container">
                        <h2 class="form-header">Confirmation</h2>
                        <a href="#" class="edit-form-btn" data-type="confirmation">edit</a>
                    </div>
                    <div class="form-input-container">
                        <p>Please confirm your review your order and confirm.</p>
                        {{-- <input type="submit" class="fill_btn w-100" value="Purchase"> --}}
                        <button type="submit" class="fill_btn w-100">Purchase</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="right cart w-50">
            <h2>Cart</h2>
            <div class="list-container" id="listContainer">
                @if (count($cartData) > 0)
                    @foreach ($cartData as $c)
                        <div class="item animate__animated animate__fadeIn">
                            <div class="item-info">
                                <img src="{{ asset('assets/vendor/images/pdf.jpg') }}" alt="">
                                <span class="item-name">{{ $c->product->name }}</span>
                                <span class="price">$ {{ $c->price }}</span>
                            </div>
                            <button class="remove-btn" id="removeCartBtn"
                                data-slug="{{ $c->product->slug }}">Remove</button>
                        </div>
                    @endforeach
                @else
                    <h2 class="placeholder">There is no item inside cart.</h2>
                    <script>
                        window.location.href = '/'; // If there is no cart item inside cart redirect to home page
                    </script>
                @endif
            </div>
            <div class="total-container">
                <div class="sub-container pale">
                    <span>Subtotal</span>
                    <span id="subTotal">$ {{ $subTotal }}</span>
                </div>
                <div class="sub-container pale">
                    <span>Tax</span>
                    <span id="tax">$ {{ $company->tax }}</span>
                </div>
                <div class="sub-container main">
                    <span>Total</span>
                    <span id="total">$ {{ $total }}</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('/assets/script/edit-info-cart.js') }}"></script>
    <script src="{{ asset('/assets/script/removeCart.js') }}"></script>
    <script src="{{ asset('/assets/script/getAllCountries.js') }}"></script> {{-- Get all countries --}}

    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');

        var elements = stripe.elements();
        var cardElement = elements.create('card');

        cardElement.mount('#card-element');

        var cardErrors = document.getElementById('card-errors');

        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                cardErrors.textContent = event.error.message;
            } else {
                cardErrors.textContent = '';
            }
        });

        // var form = document.getElementById('payment-form');
        // form.addEventListener('submit', function(event) {
        //     event.preventDefault();

        //     stripe.createToken(cardElement).then(function(result) {
        //         if (result.error) {
        //             cardErrors.textContent = result.error.message;
        //         } else {
        //             stripeTokenHandler(result.token);
        //         }
        //     });
        // });

        // function stripeTokenHandler(token) {
        //     var form = document.getElementById('confirmForm');
        //     var hiddenInput = document.createElement('input');
        //     hiddenInput.setAttribute('type', 'hidden');
        //     hiddenInput.setAttribute('name', 'stripeToken');
        //     hiddenInput.setAttribute('value', token.id);
        //     form.appendChild(hiddenInput);
        //     // form.submit();
        // }
    </script>

    {{-- <script src="{{ asset('/assets/script/payment.js') }}"></script> Stripe Payment --}}
@endsection
