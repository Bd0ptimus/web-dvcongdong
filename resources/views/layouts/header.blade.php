<link href="{{ asset('css/layouts/header.css?v=') . time() }}" rel="stylesheet">
@include('layouts.sidebar')
@php
    use App\Admin;
@endphp
{{-- <div class="row justify-content-between mb-only" style="width:100%; margin:0px;">
    <div class="left-side col-md-6 d-flex justify-content-start">
        <div class="flex-column flex-shrink-0 px-1 py-3 bg-light open-sidebar-btn vertical-container mx-1"
            style="width : 30px; cursor:pointer;" onclick="mbOpenFullSidebar()">
            <div
                class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto link text-decoration-none vertical-element-middle-align">
                <span class="mb-open-sidebar-icon">
                    <i class="fa-solid fa-bars fa-xl fs-4"></i>
                </span>
            </div>
        </div>
        <div id="logo-sec" style="margin:10px 20px;" class="d-flex justify-content-center">
            <a href="/"
                class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto link text-decoration-none">
                <span class="fs-4">Logo</span>
            </a>
        </div>
        @if (isset($isHome) && $isHome == true)
            <div id="function" class="col-md-2 vertical-container">
                <select class="cityChoosing" name="main-city">
                    <option value="">Toàn Nga</option>
                    @if (isset($cities))
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->city }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endif

        <div id="function" class="header-function-sec">
            <div id="currency" style="display:block; justify-content:center;">
                <div class="header-function-text">Tỷ Giá USD:</div>
                <div class="header-function-text">25,1-62 </div>
            </div>
        </div>
    </div>

    <div class="right-side col-md-4 d-flex justify-content-center row">

        <div id="login-register" class="col-md-8 justify-content-center">
            <a href="{{ route('login') }}"
                class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto m-0 link text-decoration-none login-res-a"
                style="margin:auto;">
                <span class="fs-4" style="display: flex; justify-content:center;"><i
                        class="fa-solid fa-right-to-bracket fa-ms login-res-a-icon"></i>
                    <p class="login-register-text"> Đăng nhập</p>
                </span>
            </a>
            <a href="{{ route('register') }}"
                class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto m-0 link text-decoration-none login-res-a"
                style="margin:auto;">
                <span class="fs-4" style="display: flex; justify-content:center;"><i
                        class="fa-regular fa-registered fa-ms login-res-a-icon"></i>
                    <p class="login-register-text"> Đăng ký</p>
                </span>
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-between pc-only" style="width:100%;">
    <div class="left-side col-md-6 d-flex justify-content-start" style="margin:auto;">
        <div id="logo-sec" class="d-flex justify-content-center" style="margin:10px 20px 10px 50px;">
            <a href="/"
                class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto link text-decoration-none">
                <span class="fs-4">Logo</span>
            </a>
        </div>


        <div id="function" class="header-function-sec">
            <div id="currency" style="display:block; justify-content:center;">
                <div class="header-function-text">Tỷ Giá USD:</div>
                <div class="header-function-text">25,1-62 </div>
            </div>
        </div>
        @if (isset($isHome) && $isHome == true)
            <div id="function" class="col-md-4 vertical-container">
                <select class="cityChoosing vertical-element-middle-align" name="main-city">
                    <option value="">Toàn Nga</option>
                    @if (isset($cities))
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->city }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endif
    </div>

    <div class="right-side col-md-4 d-flex justify-content-center row" style="margin:auto;">

        <div id="login-register" class="col-md-8 justify-content-center">
            @if (Admin::user() == null)
                <a href="{{ route('login') }}"
                    class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto m-0 link text-decoration-none login-res-a"
                    style="margin:auto;">
                    <span class="fs-4" style="display: flex; justify-content:center;"><i
                            class="fa-solid fa-right-to-bracket fa-ms login-res-a-icon"></i>
                        <p class="login-register-text"> Đăng nhập</p>
                    </span>
                </a>
                <a href="{{ route('register') }}"
                    class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto m-0 link text-decoration-none login-res-a"
                    style="margin:auto;">
                    <span class="fs-4" style="display: flex; justify-content:center;"><i
                            class="fa-regular fa-registered fa-ms login-res-a-icon"></i>
                        <p class="login-register-text"> Đăng ký</p>
                    </span>
                </a>
            @else
                <li class="nav-item dropdown" style="list-style-type: none;">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Đăng xuất
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endif

        </div>
    </div>
</div>


<div class="row justify-content-between tablet-only" style="width:100%;">
    <div class="left-side col-md-6 d-flex justify-content-start">
        <div class="flex-column flex-shrink-0 px-1 py-3 bg-light open-sidebar-btn vertical-container mx-5"
            style="width : 30px; cursor:pointer; " onclick="mbOpenFullSidebar()">
            <div
                class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto link text-decoration-none vertical-element-middle-align">
                <span class="mb-open-sidebar-icon">
                    <i class="fa-solid fa-bars fa-xl fs-4"></i>
                </span>
            </div>
        </div>
        <div id="logo-sec" style="margin:10px 20px; padding:5px;" class="d-flex justify-content-center">
            <a href="/"
                class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto link text-decoration-none">
                <span class="fs-4">Logo</span>
            </a>
        </div>

        @if (isset($isHome) && $isHome == true)
            <div id="function" class="col-md-4 vertical-container">
                <select class="cityChoosing vertical-element-middle-align" name="main-city">
                    <option value="">Toàn Nga</option>
                    @if (isset($cities))
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->city }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endif

    </div>

    <div class="right-side col-md-4 d-flex justify-content-center row">
        <div id="function" class="header-function-sec col-md-6">
            <div id="currency" style="display:block; justify-content:center;">
                <div class="header-function-text">Tỷ Giá USD:</div>
                <div class="header-function-text">25,1-62 </div>
            </div>
        </div>
    </div>
</div> --}}

<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm"
    style="position:fixed; z-index:2000; right:0px; width:100%; top:0px; background-color:rgb(248,249,250);">
    <div class="container">
        <div class="d-flex justify-content-start">
            <button onclick="sidebarOpen()" id="toggler-btn" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}" style="margin:0px 2%;">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        @if (isset($isHome) && $isHome == true)
            <form id="function" class="col-md-2 vertical-container" action="{{route('home')}}" method="post"> @csrf
                <select class="cityChoosing vertical-element-middle-align" id="mainCitySelect" name="mainCity">
                    <option value="">Toàn Nga</option>
                    @if (isset($cities))
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if($cityChoosen == $city->id ) selected @endif>{{ $city->city }}</option>
                        @endforeach
                    @endif
                </select>
            </form>
        @endif


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
<script>
    $(document).ready(function() {
        function formatText(icon) {
            return $('<span><i class="fa-solid fa-location-dot"></i> ' + icon.text + '</span>');
        };
        $('.cityChoosing').select2({
            width: "100%",
            templateSelection: formatText,
            selectionCssClass: 'header-function-sec',
        });

        $('#mainCitySelect').on('change', function(){
            $('#function').submit();
        });
    });
    $('#positon').on('click', function() {
        console.log('on click');
    });

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
