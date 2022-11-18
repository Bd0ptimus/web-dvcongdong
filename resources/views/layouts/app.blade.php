<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/04e9a3dbb4.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script type="text/javascript">
        function removePreviewImage(idForRemove, inputId) {
            document.getElementById(`${inputId}`).value = "";
            // var file = document.getElementById('logoUpload').value;
            // console.log("check file exists: " + file);
            $(`#${idForRemove}`).empty();
        }

        function setButtonActiveDisabled(control, id) {
            console.log('in set btn active');
            //control 0: active-1: disabled
            if (control == 0) {
                $(`#${id}`).removeClass('button-disabled');
                $(`#${id}`).addClass('button-active');
                $(`#${id}`).removeAttr("disabled");
            } else {
                $(`#${id}`).removeClass('button-active');
                $(`#${id}`).addClass('button-disabled');
                $(`#${id}`).attr("disabled", true);

            }
        }

        var sidebarOpened = false;

        function sidebarOpen() {
            if (!sidebarOpened) {
                $('#toggler-btn').empty();
                $('#toggler-btn').append('<i class="fa-solid fa-x"></i>');
                $('#full-sidebar').show();
                $('#full-sidebar').addClass('slide-out');
                $('#full-sidebar').removeClass('slide-in');
                sidebarOpened = true;
            } else {
                $('#toggler-btn').empty();
                $('#toggler-btn').append('<i class="fa-solid fa-bars"></i>');
                $('#full-sidebar').hide();
                $('#full-sidebar').addClass('slide-in');
                $('#full-sidebar').removeClass('slide-out');
                sidebarOpened = false;
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/app.css?v=') . time() }}" rel="stylesheet">
    <link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
    <link href="{{ asset('css/index.css?v=') . time() }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link href="{{ asset('css/layouts/header.css?v=') . time() }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="position:fixed; z-index:9999; right:0px; width:100%;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button onclick="sidebarOpen()" id="toggler-btn" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                @include('layouts.sidebar')
                {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div> --}}
            </div>
        </nav>

        {{-- <main class="py-4">
            @yield('content')
        </main> --}}
    </div>
</body>

</html>
