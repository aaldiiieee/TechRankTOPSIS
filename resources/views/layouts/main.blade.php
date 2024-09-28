<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

        <title>DMS | @yield('title')</title>

        <link rel="stylesheet" href="{{ asset('vendor/css/sb-admin-2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @yield('styles')

    </head>
    <body>

        <main id="wrapper">

            @include('partials.sidebar')

            <div id="content-wrapper" class="d-flex flex-column">

                <div id="content">

                    @include('partials.header')

                    <div class="container-fluid">

                        @yield('content')

                    </div>

                </div>

            </div>

        </main>
        
        {{-- Vendor --}}
        <script src="{{ asset('vendor/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/js/sb-admin-2.js') }}"></script>
        <script src="{{ asset('vendor/js/sweetalert2@11.js')}}"></script>
        <script src="{{ asset('vendor/js/Chart.min.js') }}"></script>

        @include('partials.scripts')

        @yield('scripts')
    </body>
</html>
