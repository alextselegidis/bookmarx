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
<body class="main-layout d-flex flex-column h-100">
<div class="flex-shrink-0">
    @include('shared.header')

    <!-- Page Heading -->

    @hasSection('pageTitle')
        <header class="bg-body-secondary mb-3">
            <div class="container">
                <div class="row">

                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <span class="navbar-brand fw-bolder text-body-secondary">
                                @yield('pageTitle')
                            </span>

                            @hasSection('pageActions')
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#page-navbar-actions">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="page-navbar-actions">
                                    <nav class="navbar-nav ms-lg-auto mb-2 mb-lg-0">
                                        @yield('pageActions')
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </nav>

                </div>
            </div>
        </header>
    @endif

    @if (session('success'))
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main class="container">
        <div class="row">
            <div class="col">
                @yield('content')
            </div>
        </div>
    </main>

</div>

@include('shared.footer')


<script src="vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="scripts/bookmarx.js?{{config('app.version')}}"></script>

@yield('scripts')
</body>
</html>
