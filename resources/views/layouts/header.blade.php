<link href="{{ asset('css/layouts/header.css?v=') . time() }}" rel="stylesheet">
@include('layouts.sidebar')
@php
    use App\Admin;
@endphp
<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm"
    style="position:fixed; z-index:1000; right:0px; width:100%; top:0px; background-color:rgb(248,249,250); height:56px;">
    <div class="d-flex justify-content-between" style="width:100%; height:100%; padding : 0px; margin:0px 5px;">
        <div class="d-flex justify-content-start" >
            <button onclick="sidebarOpen()" id="toggler-btn" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}" style="padding : 0px 5px; width:40px;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <img onclick="logoClick()" src="{{asset('storage/logo/logo1-a.jpg')}}" style="z-index:1500; height : 40px;width:auto; cursor:pointer;">
            <a class="navbar-brand pc-only" href="{{ url('/') }}" style="margin:0px 2%;z-index:1500;" >
                {{ config('app.name', 'Laravel') }}
            </a>
            {{-- <a class="navbar-brand tablet-only" href="{{ url('/') }}" style="margin:0px 2%;">
                {{ config('app.name', 'Laravel') }}
            </a>
            <a class="navbar-brand mb-only" href="{{ url('/') }}" style="margin:0px 1%;">
                logo
            </a> --}}
        </div>

        <div class="searchingForm-mb">
            <form action="{{ route('search.homeSearch') }}"
                method="post"> @csrf
                <select class="citySelect-mb" name="homeFilterPosition" id="citySelectionSearch-mb">
                    <option value="0">Toàn Nga</option>
                    @if(Cookie::get('nguoiviettainga-cities') !== null)
                        @foreach (json_decode(Cookie::get('nguoiviettainga-cities'),true) as $city)
                            <option value="{{ $city['id'] }}">
                            {{ $city['city'] }}</option>
                        @endforeach
                    @endif
                </select>
                <input autocomplete="off"
                    class="searchInputField-mb"
                    id="Filter_Keyword" name="homeFilterKeyWord" placeholder="Từ khóa" type="text" value="">
                <button
                    class=" btn btn-block btn-topcv-primary btn-border btn-border-thin searchInputBtn-mb-pc-tb"
                    type="submit" name="homeFilterClassify" value="0">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
        {{-- {{dd(json_decode(Cookie::get('nguoiviettainga-cities'),true))}} --}}

        <div class="searching-sec-pc-tb d-flex justify-content-center">
            <form class="searchingForm-pc-tb" action="{{ route('search.homeSearch') }}"
                method="post"> @csrf
                <select class="citySelect-pc-tb" name="homeFilterPosition" id="citySelectionSearch-pc-tb">
                    <option value="0">Toàn Nga</option>
                    @if(Cookie::get('nguoiviettainga-cities') !== null)
                        @foreach (json_decode(Cookie::get('nguoiviettainga-cities'),true) as $city)
                            <option value="{{ $city['id'] }}">
                            {{ $city['city'] }}</option>
                        @endforeach
                    @endif

                </select>
                <input autocomplete="off"
                    class="searchInputField-pc-tb"
                    id="Filter_Keyword" name="homeFilterKeyWord" placeholder="Từ khóa" type="text" value="">
                <button
                    class=" btn btn-block btn-topcv-primary btn-border btn-border-thin searchInputBtn-mb-pc-tb"
                    type="submit" name="homeFilterClassify" value="0">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

        @if (isset($isHome) && $isHome == true)
            {{-- <form id="function" class="col-md-2 vertical-container pc-only" action="{{ route('home') }}"
                method="post"> @csrf
                <select class="cityChoosing vertical-element-middle-align" id="mainCitySelect" name="mainCity">
                    <option value="">Toàn Nga</option>
                    @if (isset($cities))
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if ($cityChoosen == $city->id) selected @endif>
                                {{ $city->city }}</option>
                        @endforeach
                    @endif
                </select>
            </form> --}}
        @endif
    </div>
</nav>

<!--Footer-->
<nav class="navbar navbar-expand-md navbar-light bg-light shadow-lg bg-body rounded mb-only"
    style="position:fixed; z-index:1000; right:0px; width:100%; bottom:0px; background-color:rgb(248,249,250); height:56px;">
    <div class="d-flex justify-content-around" style="width:100%; height:100%; padding : 0px; margin:0px 5px;">
        <div class="d-flex justify-content-center"  onclick="window.scrollTo(0, 0);">
            <i class="fa-solid fa-house fa-2xl footer-icon"></i>
        </div>
        <div class="d-flex justify-content-center">
            <i class="fa-solid fa-headset fa-2xl footer-icon"></i>
        </div>
        @if(Admin::user()==null)
            <div class="d-flex justify-content-center">
                <i class="fa-solid fa-right-to-bracket fa-2xl footer-icon" onclick="window.location.href='{{route('auth.login')}}';"></i>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <i class="fa-regular fa-comment fa-2xl footer-icon"></i>
            </div>
        @endif
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

        $('#mainCitySelect').on('change', function() {
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
            $('#toggler-btn').append('<i class="fa-solid fa-bars "></i>');
            $('#full-sidebar').hide();
            $('#full-sidebar').addClass('slide-in');
            $('#full-sidebar').removeClass('slide-out');
            sidebarOpened = false;
        }
    }

    function logoClick(){
        console.log('logo click');
        window.location.href = '{{route("home")}}'
    }
</script>
