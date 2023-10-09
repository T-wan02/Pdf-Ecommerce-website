@extends('master')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/style/list.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/product-detail.css') }}">
@endsection

@section('content')
    @include('nav')

    <section class="item">
        <div class="navigate" style="margin-top: 8rem;">Guide > Test</div>

        <div class="product-detail">
            <img src="{{ $product->img_url }}" alt="" class="item-img">
            <div class="info">
                <h3 class="name">{{ $product->name }}</h3>
                <span class="price">$ {{ $product->price }}</span>
                <div class="content-container">
                    <div class="content">
                        <p class="paragraph">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fuga natus, quisquam nisi sunt
                            omnis suscipit doloremque! Officia porro eos minus alias, nesciunt mollitia laudantium qui
                            recusandae maiores! Quibusdam, accusantium at.
                        </p>
                        <p class="paragraph">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. In voluptate quis assumenda
                            consectetur sequi provident? Animi, praesentium maiores. Mollitia, quia.
                        </p>
                        <p class="paragraph">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis, necessitatibus?
                        </p>
                    </div>
                    <button class="purchase-btn" id="purchaseBtn" data-slug="{{ $product->slug }}">Purchase</button>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonial-list">
        <div class="item">
            <div class="header">
                <h1>Testimonial 1</h1>
            </div>
            <img src="{{ asset('assets/vendor/images/pdf.jpg') }}" alt="pdf images">
        </div>
        <div class="item">
            <div class="header">
                <h1>Testimonial 2</h1>
            </div>
            <img src="{{ asset('assets/vendor/images/pdf.jpg') }}" alt="pdf images">
        </div>
        <div class="item">
            <div class="header">
                <h1>Testimonial 3</h1>
            </div>
            <img src="{{ asset('assets/vendor/images/pdf.jpg') }}" alt="pdf images">
        </div>
        <div class="item">
            <div class="header">
                <h1>Testimonial 4</h1>
            </div>
            <img src="{{ asset('assets/vendor/images/pdf.jpg') }}" alt="pdf images">
        </div>
        <div class="item">
            <div class="header">
                <h1>Testimonial 5</h1>
            </div>
            <img src="{{ asset('assets/vendor/images/pdf.jpg') }}" alt="pdf images">
        </div>
    </section>

    @include('sign-up')

    <a href="{{ url('/cart') }}" class="cart-btn fill_btn" id="cartBtn"><i class="fa-solid fa-cart-shopping"> <span
                id="cartCount"></span></i></a>
@endsection

@section('script')
    <script>
        let cartCount = {!! $cartCount !!};
    </script>
    <script src="{{ asset('/assets/script/purchase.js') }}"></script>
@endsection
