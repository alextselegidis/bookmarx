{{--
/* ----------------------------------------------------------------------------
 * Bookmarx - Open Source Telemetry
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://bookmarx.org
 * ---------------------------------------------------------------------------- */
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <base href="{{url('')}}">

    <title>@yield('pageTitle') | Bookmarx</title>

    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/bookmarx.css?{{config('app.version')}}">

    @yield('styles')
</head>
<body class="bg-light auth-layout">

<div class="d-flex justify-content-center align-items-center min-vh-100">

    <div class="bg-white w-100 rounded-lg-4 py-lg-4 min-vh-100 min-vh-lg-unset d-flex flex-column justify-content-center d-lg-block" style="max-width: 500px;">

        <div class="text-center mt-3 mt-lg-5 mb-3">
            <img src="images/logo.png" alt="logo" class="public-logo-image" style="width: 128px"/>
        </div>

        @yield('content')

        <div class="text-center small my-5">
            Powered By
            <a href="https://bookmarx.org" target="_blank">
                Bookmarx
            </a>
        </div>

    </div>

</div>

<script src="vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="scripts/bookmarx.js?{{config('app.version')}}"></script>

@yield('scripts')
</body>
</html>
