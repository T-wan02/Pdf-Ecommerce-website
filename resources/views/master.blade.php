<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/vendor/images/The Vault Header Photo.jpg') }}">
    <title>Ecommerce Pdf Website</title>

    <!-- Css Link -->
    <link rel="stylesheet" href="{{ asset('assets/style/index.css') }}">
    @yield('style')

    <!-- Google Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind:wght@300;500;700&family=Noto+Sans:wght@200;300;400;500&display=swap"
        rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Animate css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>

    @yield('content')

</body>
<!-- Fontawesome Logo Link -->
<script src="https://kit.fontawesome.com/9d8e63c428.js" crossorigin="anonymous"></script>
{{-- Axios link --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js"
    integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('assets/script/nav.js') }}"></script> <!-- Nav scrolling js -->
<script src="{{ asset('assets/script/uniqueId.js') }}"></script> <!-- Generate Unique ID -->

@yield('script')

<script src="{{ asset('assets/script/index.js') }}"></script> <!-- Index js -->

</html>
