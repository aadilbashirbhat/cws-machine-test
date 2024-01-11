<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Adventure, Tours, Travel">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', '') {{ __( '| CWS Machine Test') }} </title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Include your stylesheets here -->
    @include('includes.styles')
    @stack('head') <!-- Allow additional styles to be pushed from views -->
</head>

<body>
    <!-- Include the preloader partial -->
    @include('partials.side_nav')
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">

        <!-- Include the Header partial -->
        @include('partials.header')

        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                @yield('content')
                <!-- Include the Footer partial -->
                @include('partials.footer')
            </div>
        </div>

    </div>
    <!-- Include your scripts here -->
    @include('includes.scripts')
    @stack('bottom-scripts') <!-- Allow additional scripts to be pushed from views -->
</body>

</html>