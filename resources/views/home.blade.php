{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!doctype html>
<html lang="vi">

@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
@endphp
<link href="{{ asset('css/mainScreen/index.css?v=') . time() }}" rel="stylesheet">

<body style="position:relative;">

    <div class="project-content-section">
        <div id="img-carousel">
            @include('layouts.mainBannerSlide')
            <div id="main-search-pc-tb" class="justify-content-center">
                <div class="box-search-wrapper" id="main-search-section">
                    <div class="container" style="display:block; justify-content: center;">
                        <div class="row main-filter">
                            <form id="frm-search-job" action="{{ route('search.homeSearch') }}" method="POST">@csrf
                                <div class="row">
                                    <div
                                        class="form-group col-sm-3 input-data vertical-container d-flex justify-content-center">
                                        <input autocomplete="off"
                                            class="form-control form-control-input-text ui-autocomplete-input vertical-element-middle-align"
                                            id="Filter_Keyword" name="homeFilterKeyWord" placeholder="Từ khóa"
                                            type="text" style="height: 46px; width:90%" value="">
                                    </div>
                                    <div class="form-group col-sm-3 input-data">
                                        <select class="main-filter-classify" name="homeFilterClassify">
                                            <option value="0">Tất cả</option>
                                            @foreach ($classifies as $classify)
                                                <option value="{{ $classify->id }}">{{ $classify->classify_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3 input-data">
                                        <select class="main-filter-position" name="homeFilterPosition">
                                            <option value="0">Toàn Nga</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->city }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-sm-3 search-submit vertical-container">
                                        <button
                                            class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn"
                                            type="submit" style="height: 46px; ">
                                            <i class="fa fa-search"></i><span> Tìm kiếm</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ((Admin::user() !== null && Admin::user()->isRole(ROLE_USER)) || Admin::user() == null)
                            <div class="row main-filter">
                                <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                    <button id="checkCarTicket"
                                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                        <i class="fa-solid fa-car-on"></i><span> Kiểm tra lỗi phạt xe</span>
                                    </button>
                                </div>
                                <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                    <button id="checkAdministrative"
                                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                        <i class="fa-solid fa-book"></i><span> Kiểm tra lỗi hành chính</span>
                                    </button>
                                </div>
                                <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                    <button id="checkTaxdebt"
                                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                        <i class="fa-solid fa-coins"></i><span> Kiểm tra nợ thuế</span>
                                    </button>
                                </div>
                                <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                    <button id="checkEntryBan"
                                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                        <i class="fa-solid fa-plane-circle-xmark"></i><span> Kiểm tra cấm nhập
                                            cảnh</span>
                                    </button>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <div id="main-search-mb" class="justify-content-center">
                <form id="frm-search-job" action="{{ route('search.homeSearch') }}" method="POST">@csrf
                    <div class="row" style="width : 100%; margin:auto;">
                        <div class="form-group input-data vertical-container d-flex justify-content-center"
                            style="height : 48px; margin: 10px 0px;">
                            <input autocomplete="off"
                                class="form-control form-control-input-text ui-autocomplete-input vertical-element-middle-align"
                                id="Filter_Keyword" name="homeFilterKeyWord" placeholder="Từ khóa" type="text"
                                style="height: 46px; width:93%" value="">
                        </div>
                    </div>
                    <div class="row" style="width : 100%; margin:auto;">
                        <div class="form-group input-data">
                            <select class="main-filter-classify" name="homeFilterClassify">
                                <option value="0">Tất cả</option>
                                @foreach ($classifies as $classify)
                                    <option value="{{ $classify->id }}">{{ $classify->classify_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row" style="width : 100%; margin:auto;">
                        <div class="form-group  input-data">
                            <select class="main-filter-position" name="homeFilterPosition">
                                <option value="0">Toàn Nga</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->city }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row" style="width : 100%; margin:auto; height:auto;">
                        <div class="d-flex justify-content-center search-submit vertical-container"
                            style="height : 50px;">
                            <button
                                class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn"
                                type="submit" style="height: 46px; ">
                                <i class="fa fa-search"></i><span> Tìm kiếm</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="row"
                    style="display:flex; justify-content: center; width:100%; height : 50px; margin:auto;">
                    <div class="form-group vertical-container d-flex justify-content-center" style="width:25%;">
                        <button id="checkCarTicketMb"
                            class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                            <i class="fa-solid fa-car-on"></i>
                        </button>
                    </div>
                    <div class="form-group vertical-container d-flex justify-content-center" style="width:25%;">
                        <button id="checkAdministrativeMb"
                            class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                            <i class="fa-solid fa-book"></i>
                        </button>
                    </div>
                    <div class="form-group vertical-container d-flex justify-content-center" style="width:25%;">
                        <button id="checkTaxdebtMb"
                            class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                            <i class="fa-solid fa-coins"></i>
                        </button>
                    </div>
                    <div class="form-group vertical-container d-flex justify-content-center" style="width:25%;">
                        <button id="checkEntryBanMb"
                            class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                            <i class="fa-solid fa-plane-circle-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row my-5 d-flex justify-content-between">
            <div style="width : 50%; height : auto;">
                <fxwidget-er inverse="false" amount="1" decimals="2" large="false" shadow="true" symbol="true"
                    flag="true" changes="true" grouping="true" border="false" main-curr="USD" sel-curr="RUB,VND"
                    background-color="#ffffff" lang="vi" border-radius="0.5"></fxwidget-er>
                <script async src="https://s.fx-w.io/widgets/exchange-rates/latest.js?vi"></script>
            </div>
            <div style="width : 50%; height : auto;">
                <div id="ww_b40fc5d8a12e7" v='1.3' loc='id' a='{"t":"responsive","lang":"vi","sl_lpl":1,"ids":["wl3996"],"font":"Arial","sl_ics":"one","sl_sot":"celsius","cl_bkg":"rgba(255,255,255,1)","cl_font":"#000000","cl_cloud":"#d4d4d4","cl_persp":"#2196F3","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","sl_tof":"3","el_wfc":3,"cl_odd":"#0000000a"}'>Weather Data Source: <a href="https://weerlabs.nl/weer_moskou/week/" id="ww_b40fc5d8a12e7_u" target="_blank">Moskou weer deze week</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_b40fc5d8a12e7"></script>
            </div>
        </div> --}}

        <div class="row my-5 newfeed-sec" id="home-newFeed-sec">
            <div class="row d-block justify-content-center newfeed-container2">
                <div class="row newFeed-content-small-sec2 d-flex justify-content-start">
                    <div class="newFeed-avatar-sec d-flex justify-content-start">
                        <div class="newFeed-avatar-container d-flex justify-content-center">
                            <img class="newFeed-avatar" src={{ asset('storage/avatar-sample/ava1.jpg') }}>
                        </div>
                    </div>

                    <div class="newFeed-posterinfo-sec d-block justify-content-center">
                        <p class="newFeed-posterinfo-text" style="font-size : 17px; font-weight : 900;">Tên người dùng
                        </p>
                        <p class="newFeed-posterinfo-text">
                            <span>2 ngày trước</span>
                            <span><i class="fa-solid fa-location-dot"></i>   moscow</span>
                            <span class="newFeed-post-hashtag">
                                Nhà đất
                            </span>
                        </p>
                    </div>
                </div>

                <div style="padding:0px;" class="d-flex justify-content-center">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide ">
                                <img class="newFeed-image2" src={{ asset('storage/test/test1.jpg') }}>
                            </div>
                            <div class="swiper-slide ">
                                <img class="newFeed-image2" src={{ asset('storage/test/test2.jpg') }}>
                            </div>
                            <div class="swiper-slide ">
                                <img class="newFeed-image2" src={{ asset('storage/test/test3.jpg') }}>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                </div>
                <div class="row newFeed-content-small-sec2 d-flex justify-content-between">
                    <div class="newFeed-detail-icon">
                        <span class="fa fa-star rating-star-checked"></span>
                        <span class="fa fa-star rating-star-checked"></span>
                        <span class="fa fa-star rating-star-checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>

                    <div class="newFeed-detail-icon">
                        <span> Đánh giá</span>
                    </div>

                    <div class="newFeed-detail-icon">
                        <span> 4 lượt truy cập</span>
                    </div>
                </div>

                <div class="row newFeed-content-small-sec2 ">
                    <div class="row newFeed-info-title-sec2">
                        <p class="newFeed-info-title2">Australian Citizenship Test
                            Revision at LCViet Australia - 98% Successful Rate</p>
                    </div>
                    <div class="row newFeed-info-text-sec2">
                        <p class="newFeed-info-text2">AUSTRALIAN
                            CITIZENSHIP.

                            Call 0452 511 577 (Ms. Esther) We are please to boast a 98% SUCCESSFUL
                            RATE</p>
                    </div>
                    <hr />
                </div>

                <div class="row newFeed-interact-sec2 d-flex justify-content-center">
                    <i style="color:red;" class="fa-solid fa-heart fa-xl interact-icon2"></i>
                </div>
            </div>


            {{-- <div class="row newfeed-container d-flex justify-content-center">
                <div class="row newfeed-content-sec">
                    <div class="newfeed-image-sec  newFeed-image-sec">
                        <img class="newFeed-image" src={{ asset('storage/template/post/none-pic-logo.jpg') }}>
                    </div>

                    <div class="newfeed-info-sec d-block justify-content-center">
                        <div class="row newFeed-info-title-sec vertical-container">
                            <p class="newFeed-info-title vertical-element-middle-align">Australian Citizenship Test
                                Revision at LCViet Australia - 98% Successful Rate</p>
                        </div>
                        <div class="row newFeed-info-content-sec">
                            <div class="row newFeed-info-description-sec vertical-container">
                                <p class="newFeed-info-description vertical-element-middle-align">AUSTRALIAN
                                    CITIZENSHIP. Call 0452 511 577 (Ms. Esther) We are please to boast a 98% SUCCESSFUL
                                    RATE</p>
                            </div>
                            <div class="row newFeed-info-detail-sec">
                                <div class="newFeed-detail-icon">
                                    <i class="fa-solid fa-location-dot"></i><span> Moscow</span>
                                </div>

                                <div class="newFeed-detail-icon">
                                    <i class="fa-solid fa-bars"></i><span> Nhà đất</span>
                                </div>

                                <div class="newFeed-detail-icon">
                                    <i class="fa-solid fa-clock"></i><span> 2 ngày trước</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            @foreach ($posts as $post)
                @php
                    $avatarPath = 'storage/avatar-sample/ava1.jpg';
                    if($post->user->user_avatar != null){
                        $avatarPath=$post->user->user_avatar ;
                    }

                    $postAddress = 'Toàn Nga';
                    if (isset($post->city)) {
                        $postAddress = $post->city->city;
                    }

                    $postClassify = CLASSIFY_SLUG[$post->posts_classify_type];
                    if ($post->posts_classify_type == SERVICE_SLUG) {
                        $postClassify = $postClassify . ', ' . SERVICE_TYPE_SLUG[$post->posts_classify->services_type_type];
                    }

                    $now = \Carbon\Carbon::now();
                    $createdAt = \Carbon\Carbon::parse($post->created_at);
                    $postTimes = $createdAt->diffInDays($now);
                    if ($postTimes == 0) {
                        $postTimes = $createdAt->diffInHours($now);
                        if ($postTimes == 0) {
                            $postTimes = 'gần đây';
                        } else {
                            $postTimes = $postTimes . ' giờ trước';
                        }
                    } elseif ($postTimes > 30) {
                        $postTimes = date('m/d/Y', strtotime($createdAt));
                    } else {
                        $postTimes = $postTimes . ' ngày trước';
                    }

                @endphp
                <div class="row d-block justify-content-center newfeed-container2">
                    <div class="row newFeed-content-small-sec2 d-flex justify-content-start">
                        <div class="newFeed-avatar-sec d-flex justify-content-start">
                            <div class="newFeed-avatar-container d-flex justify-content-center">
                                <img class="newFeed-avatar" src={{ asset($avatarPath) }}>
                            </div>
                        </div>

                        <div class="newFeed-posterinfo-sec d-block justify-content-center">
                            <p class="newFeed-posterinfo-text" style="font-size : 17px; font-weight : 900;">
                                {{$post->user->name}}
                            </p>
                            <p class="newFeed-posterinfo-text">
                                <span>{{ $postTimes }}</span>
                                <span><i class="fa-solid fa-location-dot"></i>    {{ $postAddress }}</span>
                                <span class="newFeed-post-hashtag">
                                    {{$postClassify}}
                                </span>
                            </p>
                        </div>
                    </div>
                    {{-- <div class="row newFeed-content-small-sec2 d-flex justify-content-between">
                        <div class="newFeed-detail-icon">
                            <i class="fa-solid fa-location-dot"></i><span> {{ $postAddress }}</span>
                        </div>

                        <div class="newFeed-detail-icon">
                            <i class="fa-solid fa-bars"></i><span> {{ $postClassify }}</span>
                        </div>

                        <div class="newFeed-detail-icon">
                            <i class="fa-solid fa-clock"></i><span> {{ $postTimes }}</span>
                        </div>
                    </div> --}}
                    @if (sizeof($post->post_attachments) != 0)
                        <div style="padding:0px;" class="d-flex justify-content-center">
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    @foreach ($post->post_attachments as $key => $attachment)
                                        <div class="swiper-slide ">
                                            <img class="newFeed-image2" src={{ $attachment->attachment_path }}>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>

                        </div>
                    @endif
                    <div class="row newFeed-content-small-sec2 d-flex justify-content-between">
                        <div class="newFeed-detail-icon">
                            @for($i=1; $i<6;$i++)
                                <span class="fa fa-star @if($i<=$post->rating_score)rating-star-checked @endif"></span>
                            @endfor
                        </div>

                        <div class="newFeed-detail-icon">
                            <span> Đánh giá</span>
                        </div>

                        <div class="newFeed-detail-icon">
                            <span> {{$post->access_times}} lượt truy cập</span>
                        </div>
                    </div>

                    <div class="row newFeed-content-small-sec2 ">
                        <div class="row newFeed-info-title-sec2">
                            <p class="newFeed-info-title2">{{ $post->title }}</p>
                        </div>
                        <div class="row newFeed-info-text-sec2">
                            <p class="newFeed-info-text2">{!! nl2br($post->description) !!}</p>
                        </div>

                    </div>

                    @if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER))
                        <hr />
                        <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                            id="newFeed-post-{{ $post->id }}">
                            @if ($post->checkPostLiked(Admin::user()->id, $post->id))
                                <i style="color:red;" class="fa-solid fa-heart fa-xl interact-icon2"
                                    onclick="unlikePost({{ Admin::user()->id }},{{ $post->id }},'newFeed-post-{{ $post->id }}' )"></i>
                            @else
                                <i class="fa-regular fa-heart fa-xl interact-icon2"
                                    onclick="likePost({{ Admin::user()->id }},{{ $post->id }},'newFeed-post-{{ $post->id }}' )"></i>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach


            {{-- @foreach ($posts as $post)
                <div class="row newfeed-container d-flex justify-content-center">
                    <div class="row newfeed-content-sec">
                        <div class="newfeed-image-sec  newFeed-image-sec">
                            @php
                                $imgPath = 'storage/template/post/none-pic-logo.jpg';
                                foreach ($post->post_attachments as $attachment) {
                                    if ($attachment->attachment_type == POST_DESCRIPTION_PHOTO) {
                                        $imgPath = $attachment->attachment_path;
                                        break;
                                    }
                                }

                                $postAddress = 'Toàn Nga';
                                if (isset($post->city)) {
                                    $postAddress = $post->city->city;
                                }

                                $postClassify = CLASSIFY_SLUG[$post->posts_classify_type];
                                if ($post->posts_classify_type == SERVICE_SLUG) {
                                    $postClassify = $postClassify . ', ' . SERVICE_TYPE_SLUG[$post->posts_classify->services_type_type];
                                }

                                $now = \Carbon\Carbon::now();
                                $createdAt = \Carbon\Carbon::parse($post->created_at);
                                $postTimes = $createdAt->diffInDays($now);
                                if ($postTimes == 0) {
                                    $postTimes = $createdAt->diffInHours($now);
                                    if ($postTimes == 0) {
                                        $postTimes = 'gần đây';
                                    } else {
                                        $postTimes = $postTimes . ' giờ trước';
                                    }
                                } elseif ($postTimes > 30) {
                                    $postTimes = date('m/d/Y', strtotime($createdAt));
                                } else {
                                    $postTimes = $postTimes . ' ngày trước';
                                }

                            @endphp
                            <img class="newFeed-image" src={{ asset($imgPath) }}>

                        </div>

                        <div class="newfeed-info-sec d-block justify-content-center">
                            <div class="row newFeed-interact-sec d-flex justify-content-end">
                                @if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER))
                                    <span class="newFeed-icon-sec" id="newFeed-post-{{ $post->id }}">
                                        @if ($post->checkPostLiked(Admin::user()->id, $post->id))
                                            <i style="color:red;" class="fa-solid fa-heart"
                                                onclick="unlikePost({{ Admin::user()->id }},{{ $post->id }},'newFeed-post-{{ $post->id }}' )"></i>
                                        @else
                                            <i class="fa-regular fa-heart"
                                                onclick="likePost({{ Admin::user()->id }},{{ $post->id }},'newFeed-post-{{ $post->id }}' )"></i>
                                        @endif
                                    </span>
                                @endif
                            </div>
                            <div class="row newFeed-info-title-sec vertical-container">
                                <p class="newFeed-info-title vertical-element-middle-align">{{ $post->title }}</p>
                            </div>
                            <div class="row newFeed-info-content-sec">
                                <div class="row newFeed-info-description-sec vertical-container"
                                    style="overflow:hidden;">
                                    <p class="newFeed-info-description vertical-element-middle-align"
                                        style="overflow:hidden;">
                                        {!! nl2br($post->description) !!}</p>
                                </div>
                                <div class="row newFeed-info-detail-sec">
                                    <div class="newFeed-detail-icon">
                                        <i class="fa-solid fa-location-dot"></i><span> {{ $postAddress }}</span>
                                    </div>

                                    <div class="newFeed-detail-icon">
                                        <i class="fa-solid fa-bars"></i><span> {{ $postClassify }}</span>
                                    </div>

                                    <div class="newFeed-detail-icon">
                                        <i class="fa-solid fa-clock"></i><span> {{ $postTimes }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}
            {{-- <div class="row newfeed-container d-flex justify-content-center">
                <div class="row newfeed-content-sec">
                    <div class="newfeed-image-sec  newFeed-image-sec">
                        <img class="newFeed-image" src={{ asset('storage/template/post/none-pic-logo.jpg') }}>
                    </div>

                    <div class="newfeed-info-sec d-block justify-content-center">
                        <div class="row newFeed-info-title-sec vertical-container">
                            <p class="newFeed-info-title vertical-element-middle-align">Australian Citizenship Test
                                Revision at LCViet Australia - 98% Successful Rate</p>
                        </div>
                        <div class="row newFeed-info-content-sec">
                            <div class="row newFeed-info-description-sec vertical-container">
                                <p class="newFeed-info-description vertical-element-middle-align">AUSTRALIAN
                                    CITIZENSHIP. Call 0452 511 577 (Ms. Esther) We are please to boast a 98% SUCCESSFUL
                                    RATE</p>
                            </div>
                            <div class="row newFeed-info-detail-sec">
                                <div class="newFeed-detail-icon">
                                    <i class="fa-solid fa-location-dot"></i><span> Moscow</span>
                                </div>

                                <div class="newFeed-detail-icon">
                                    <i class="fa-solid fa-bars"></i><span> Nhà đất</span>
                                </div>

                                <div class="newFeed-detail-icon">
                                    <i class="fa-solid fa-clock"></i><span> 2 ngày trước</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> --}}


        </div>
    </div>
    @include('templates.notification.toast');
</body>

<script>
    var numberLoadingStep = 1;
    var allowLoad = true;
    let swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    function swiperReload() {
        swiper = new Swiper(`.mySwiper${numberLoadingStep-1}`, {
            pagination: {
                el: ".swiper-pagination",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }

    window.onscroll = function(ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight - 50) {
            // you're at the bottom of the page
            if (allowLoad) {
                allowLoad = false;
                newFeedLoadMoreData();
            }
            console.log("Bottom of page");
        }
    };

    function newFeedLoadMoreData() {
        $.ajax({
            method: 'post',
            url: '{{ route('home.homeNewFeedLoading') }}',
            data: {
                cityChoosing: <?= $cityChoosen ?? 0 ?>,
                numberStep: numberLoadingStep,
                userId: {{ Admin::user() !== null ? Admin::user()->id : 0 }},
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                console.log('step: ', numberLoadingStep);

                if (data['error'] == 0) {
                    console.log('Data length : ', data.data.length);
                    data.data.forEach(function(e) {
                        var likeIcon = '';
                        if (e.isUser) {
                            var userId = {{ Admin::user() !== null ? Admin::user()->id : 0 }};
                            if (!e.liked) {
                                likeIcon = `<hr /><div class="row newFeed-interact-sec2 d-flex justify-content-center" id="newFeed-post-${e.id}">
                                                <i class="fa-regular fa-heart fa-xl interact-icon2" onclick="likePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>
                                            </div>`;
                                // `<i class="fa-regular fa-heart" onclick="likePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>`;
                            } else {
                                likeIcon = `<hr /><div class="row newFeed-interact-sec2 d-flex justify-content-center" id="newFeed-post-${e.id}">
                                                <i style="color:red;" class="fa-solid fa-heart fa-xl interact-icon2" onclick="unlikePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>
                                            </div>`;
                                // `<i style="color:red;" class="fa-solid fa-heart" onclick="unlikePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>`;
                            }
                        }
                        var images = '';
                        if (e.images.length > 0) {
                            for (var i = 0; i < e.images.length; i++) {
                                images = images + `<div class="swiper-slide ">
                                                        <img class="newFeed-image2" src="${e.images[i]}">
                                                    </div>`;
                            }
                        }
                        $('#home-newFeed-sec').append(`<div class="row d-block justify-content-center newfeed-container2">
                                                                        <div class="row newFeed-content-small-sec2 d-flex justify-content-start">
                                                                <div class="newFeed-avatar-sec d-flex justify-content-start">
                                                                    <div class="newFeed-avatar-container d-flex justify-content-center">
                                                                        <img class="newFeed-avatar" src='${e.avatar}'>
                                                                    </div>
                                                                </div>

                                                                <div class="newFeed-posterinfo-sec d-block justify-content-center">
                                                                    <p class="newFeed-posterinfo-text" style="font-size : 17px; font-weight : 900;">
                                                                        ${e.ownerName}
                                                                    </p>
                                                                    <p class="newFeed-posterinfo-text">
                                                                        <span>2 ngày trước</span>
                                                                        <span><i class="fa-solid fa-location-dot"></i>   ${e.address}</span>
                                                                        <span class="newFeed-post-hashtag">
                                                                            ${e.classify}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div style="padding:0px;" class="d-flex justify-content-center">
                                                                <div class="swiper mySwiper${numberLoadingStep}">
                                                                    <div class="swiper-wrapper">
                                                                        ${images}
                                                                    </div>
                                                                    <div class="swiper-pagination"></div>
                                                                    <div class="swiper-button-next"></div>
                                                                    <div class="swiper-button-prev"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row newFeed-content-small-sec2 d-flex justify-content-between">
                                                                <div class="newFeed-detail-icon">
                                                                    ${e.rating}
                                                                </div>

                                                                <div class="newFeed-detail-icon">
                                                                    <span> Đánh giá</span>
                                                                </div>

                                                                <div class="newFeed-detail-icon">
                                                                    <span> ${e.accessTimes} lượt truy cập</span>
                                                                </div>
                                                            </div>

                                                            <div class="row newFeed-content-small-sec2 ">
                                                                <div class="row newFeed-info-title-sec2">
                                                                    <p class="newFeed-info-title2">${e.title}</p>
                                                                </div>
                                                                <div class="row newFeed-info-text-sec2">
                                                                    <p class="newFeed-info-text2">${e.description}</p>
                                                                </div>
                                                            </div>

                                                            ${likeIcon}
                                                        </div>`);
                    })
                    if (data.data.length > 0) {
                        numberLoadingStep++;
                        swiperReload();
                    }
                }
                allowLoad = true;
            }

        });
    }


    $(document).ready(function() {
        function formatTextClassify(icon) {
            return $('<span><i class="fa-solid fa-bars"></i>     ' + icon.text + '</span>');
        };
        $('.main-filter-classify').select2({
            width: "100%",
            placeholder: 'Phân loại',
            templateSelection: formatTextClassify,
            selectionCssClass: 'header-function-sec',
        });


        function formatTextPosition(icon) {
            return $('<span><i class="fas fa-map-marker-alt"></i>     ' + icon.text + '</span>');
        };
        $('.main-filter-position').select2({
            width: "100%",
            placeholder: 'Vị trí',
            templateSelection: formatTextPosition,
            selectionCssClass: 'header-function-sec',
        });

        $('#checkCarTicket').on('click', function() {
            checkUserExist();
            modalShowMain(1);
        })

        $('#checkAdministrative').on('click', function() {
            checkUserExist();
            modalShowMain(2);
        })

        $('#checkTaxdebt').on('click', function() {
            checkUserExist();
            modalShowMain(3);
        })

        $('#checkEntryBan').on('click', function() {
            checkUserExist();
            modalShowMain(4);
        })

        $('#checkCarTicketMb').on('click', function() {
            checkUserExist();
            modalShowMain(1);
        })

        $('#checkAdministrativeMb').on('click', function() {
            checkUserExist();
            modalShowMain(2);
        })

        $('#checkTaxdebtMb').on('click', function() {
            checkUserExist();
            modalShowMain(3);
        })

        $('#checkEntryBanMb').on('click', function() {
            checkUserExist();
            modalShowMain(4);
        })

        function modalShowMain(index) {
            //index : 1-checkCarTicket
            //index : 2-checkAdminist
            //index : 3-checkTaxdebt
            //index : 4-checkEntryBan
            controlServiceCheckingModal(index);
            $('#service-checking-modal-container').modal('show');
        }
    });


    // var $item = $('.carousel .carousel-item');
    // var $wHeight = $(window).height();
    // $item.eq(0).addClass('active');
    // $item.height($wHeight);
    // $item.addClass('full-screen');

    // $('.carousel img').each(function() {
    //     var $src = $(this).attr('src');
    //     var $color = $(this).attr('data-color');
    //     $(this).parent().css({
    //         'background-image': 'url(' + $src + ')',
    //         'background-color': $color
    //     });
    //     $(this).remove();
    // });

    // $(window).on('resize', function() {
    //     $wHeight = $(window).height();
    //     $item.height($wHeight);
    // });

    // $('.carousel').carousel({
    //     interval: 5000,
    //     pause: "false"
    // });




    const easingOutQuint = (x, t, b, c, d) =>
        c * ((t = t / d - 1) * t * t * t * t + 1) + b

    function smoothScrollPolyfill(node, key, target) {
        const startTime = Date.now()
        const offset = node[key]
        const gap = target - offset
        const duration = 1000
        let interrupt = false

        const step = () => {
            const elapsed = Date.now() - startTime
            const percentage = elapsed / duration

            if (interrupt) {
                return
            }

            if (percentage > 1) {
                cleanup()
                return
            }

            node[key] = easingOutQuint(0, elapsed, offset, gap, duration)
            requestAnimationFrame(step)
        }

        const cancel = () => {
            interrupt = true
            cleanup()
        }

        const cleanup = () => {
            node.removeEventListener('wheel', cancel)
            node.removeEventListener('touchstart', cancel)
        }

        node.addEventListener('wheel', cancel, {
            passive: true
        })
        node.addEventListener('touchstart', cancel, {
            passive: true
        })

        step()

        return cancel
    }

    function testSupportsSmoothScroll() {
        let supports = false
        try {
            let div = document.createElement('div')
            div.scrollTo({
                top: 0,
                get behavior() {
                    supports = true
                    return 'smooth'
                }
            })
        } catch (err) {} // Edge throws an error
        return supports
    }

    const hasNativeSmoothScroll = testSupportsSmoothScroll()

    function smoothScroll(node, topOrLeft, horizontal) {
        if (hasNativeSmoothScroll) {
            return node.scrollTo({
                [horizontal ? 'left' : 'top']: topOrLeft,
                behavior: 'smooth'
            })
        } else {
            return smoothScrollPolyfill(node, horizontal ? 'scrollLeft' : 'scrollTop', topOrLeft)
        }
    }

    function debounce(func, ms) {
        let timeout
        return () => {
            clearTimeout(timeout)
            timeout = setTimeout(() => {
                timeout = null
                func()
            }, ms)
        }
    }

    const indicators = document.querySelectorAll('.indicator-button')
    const scroller = document.querySelector('.scroll')

    function setAriaLabels() {
        indicators.forEach((indicator, i) => {
            indicator.setAttribute('aria-label', `Scroll to item #${i + 1}`)
        })
    }

    function setAriaPressed(index) {
        indicators.forEach((indicator, i) => {
            indicator.setAttribute('aria-pressed', !!(i === index))
        })
    }

    indicators.forEach((indicator, i) => {
        indicator.addEventListener('click', e => {
            e.preventDefault()
            e.stopPropagation()
            setAriaPressed(i)
            const scrollLeft = Math.floor(scroller.scrollWidth * (i / 4))
            smoothScroll(scroller, scrollLeft, true)
        })
    })

    scroller.addEventListener('scroll', debounce(() => {
        let index = Math.round((scroller.scrollLeft / scroller.scrollWidth) * 4)
        setAriaPressed(index)
    }, 200))

    setAriaLabels()
</script>

</html>
