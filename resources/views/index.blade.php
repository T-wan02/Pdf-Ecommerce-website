@extends('master')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/style/list.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/list.css') }}">
@endsection

@section('content')
    @include('nav')

    <section class="hero-section">
        <div class="introduction" style="margin-top: 10rem;">Use our proven playbook & guides to improve your sales, email &
            discovery game.</div>

        <div class="navigate-line"></div>

        <div class="list-container">
            @foreach ($products as $p)
                <div class="item">
                    {{-- <img src="{{ $p->img_url }}" class="item-img" alt="pdf-file"> --}}
                    <div class="info-container">
                        <h3 class="item-name">{{ $p->name }}</h3>
                        <span class="item-price">$ {{ $p->price }}</span>
                    </div>
                    <button class="outline_btn w-100 purchase-btn" data-slug="{{ $p->slug }}">
                        <i class="fa-solid fa-cart-plus"></i> Add to cart
                    </button>
                </div>
            @endforeach
        </div>
    </section>

    {{-- <a href="{{ asset('pdfs/Wan Wan Resume (1).pdf') }}" download>pdf</a> --}}

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
