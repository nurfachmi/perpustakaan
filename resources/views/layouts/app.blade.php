<!doctype html>
<html lang="en">

<head>
    <title>@yield('title', config('app.name'))</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('icon.ico') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sticky-footer-navbar.css') }}">

    @stack('css')

</head>

<body class="d-flex flex-column h-100">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                    aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('home') }}">{{__('general.home')}}</a>
                            </li>
                            @include('layouts.menu')
                            @stack('left-nav')
                        @else
                            @stack('left-nav-guest')
                        @endauth
                    </ul>

                    <ul class="navbar-nav">
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false">
                                {{strtoupper(Lang::locale())}}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="lang/id">ID</a>
                                <a class="dropdown-item" href="lang/en">EN</a>
                            </div>
                        </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('my-profile') }}">Update Profile</a>
                                    <a class="dropdown-item" href="{{ route('my-password') }}">Update Password</a>
                                    <a class="dropdown-item" href="#">Information</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                            @stack('right-nav')
                        @else
                            @stack('right-nav-guest')
                        @endauth
                    </ul>

                    @stack('nav-right')
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            @yield('body')
        </div>
    </main>

    <footer class="footer mt-3 py-3">
        <div class="container text-center">
            <span class="text-muted">{{ config('app.name') }} &copy; 2023</span>
        </div>
    </footer>

    @include('layouts.modal')
    @include('sweetalert::alert')
    <script src="{{ asset('vendor/jquery/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

    <script>
        $("form").attr('autocomplete', 'off')
        $("input").attr('autocomplete', false)
    </script>
    @yield('script')
    @stack('js')
</body>

</html>
