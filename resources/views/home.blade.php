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
        <div class="row d-flex justify-content-center" style="width:100%;">
            <div class="home-currency d-flex justify-content-center">
                <p class="home-currency-text home-currency-title">USD-RUB : </p>
                <p class="home-currency-text home-currency-text-content"
                    @if ($currencyExchange['usd_rub']['change'] < 0) style="color:red;" @else style="color:green;" @endif>
                    {{ $currencyExchange['usd_rub']['last'] }}</p>
                @if ($currencyExchange['usd_rub']['change'] < 0)
                    <i class="fa-solid fa-arrow-down fa-xs" style="color:red;"></i>
                @else
                    <i class="fa-solid fa-arrow-up fa-xs" style="color:green;"></i>
                @endif
            </div>

            <div class="home-currency d-flex justify-content-center">
                <p class="home-currency-text home-currency-title">USD-VND : </p>
                <p class="home-currency-text home-currency-text-content"
                    @if ($currencyExchange['usd_vnd']['change'] < 0) style="color:red;" @else style="color:green;" @endif>
                    {{ $currencyExchange['usd_vnd']['last'] }}</p>
                @if ($currencyExchange['usd_vnd']['change'] < 0)
                    <i class="fa-solid fa-arrow-down fa-xs" style="color:red;"></i>
                @else
                    <i class="fa-solid fa-arrow-up fa-xs" style="color:green;"></i>
                @endif
            </div>

            <div class="home-currency d-flex justify-content-center">
                <p class="home-currency-text home-currency-title">BTC-USD : </p>
                <p class="home-currency-text home-currency-text-content"
                    @if ($currencyExchange['btc_usd']['change'] < 0) style="color:red;" @else style="color:green;" @endif>
                    {{ $currencyExchange['btc_usd']['last'] }}</p>
                @if ($currencyExchange['btc_usd']['change'] < 0)
                    <i class="fa-solid fa-arrow-down fa-xs" style="color:red;"></i>
                @else
                    <i class="fa-solid fa-arrow-up fa-xs" style="color:green;"></i>
                @endif
            </div>

            <div class="home-currency d-flex justify-content-center">
                <p class="home-currency-text home-currency-title">ETH-USD : </p>
                <p class="home-currency-text home-currency-text-content"
                    @if ($currencyExchange['eth_usd']['change'] < 0) style="color:red;" @else style="color:green;" @endif>
                    {{ $currencyExchange['eth_usd']['last'] }}</p>
                @if ($currencyExchange['eth_usd']['change'] < 0)
                    <i class="fa-solid fa-arrow-down fa-xs" style="color:red;"></i>
                @else
                    <i class="fa-solid fa-arrow-up fa-xs" style="color:green;"></i>
                @endif
            </div>
        </div>
        @if ((Admin::user() !== null && Admin::user()->isRole(ROLE_USER)) || Admin::user() == null)
            <div class="row homeCheckingServiceBtn-sec">
                <div class="col-md-3 vertical-container d-flex justify-content-center main-service-checking-btn-sec">
                    <button id="checkCarTicket"
                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn d-block justify-content-center">
                        <div class="row d-flex justify-content-center" style="height: 30%;">
                            <i class="fa-solid fa-car-on fa-2xl" style="margin-top : 20px;"></i>
                        </div>
                        <div class="row d-flex justify-content-center vertical-container " style="height: 70%;">
                            <div class="vertical-element-middle-align" style="line-height : 18px;"> Kiểm tra lỗi phạt xe
                            </div>
                        </div>


                    </button>
                </div>
                <div class="col-md-3 vertical-container d-flex justify-content-center main-service-checking-btn-sec">
                    <button id="checkAdministrative"
                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn d-block justify-content-center">
                        <div class="row d-flex justify-content-center" style="height: 30%;">
                            <i class="fa-solid fa-book fa-2xl" style="margin-top : 20px;"></i>
                        </div>
                        <div class="row d-flex justify-content-center vertical-container " style="height: 70%;">
                            <div class="vertical-element-middle-align" style="line-height : 18px;"> Kiểm tra lỗi hành
                                chính</div>
                        </div>
                    </button>
                </div>
                <div class="col-md-3 vertical-container d-flex justify-content-center main-service-checking-btn-sec">
                    <button id="checkTaxdebt"
                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn d-block justify-content-center">
                        <div class="row d-flex justify-content-center" style="height: 30%;">
                            <i class="fa-solid fa-coins fa-2xl" style="margin-top : 20px;"></i>
                        </div>
                        <div class="row d-flex justify-content-center vertical-container " style="height: 70%;">
                            <div class="vertical-element-middle-align" style="line-height : 18px;"> Kiểm tra nợ thuế
                            </div>
                        </div>
                    </button>
                </div>
                <div class=" col-md-3 vertical-container d-flex justify-content-center main-service-checking-btn-sec">
                    <button id="checkEntryBan"
                        class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn d-block justify-content-center">
                        <div class="row d-flex justify-content-center" style="height: 30%;">
                            <i class="fa-solid fa-plane-circle-xmark fa-2xl" style="margin-top : 20px;"></i>
                        </div>
                        <div class="row d-flex justify-content-center vertical-container " style="height: 70%;">
                            <div class="vertical-element-middle-align" style="line-height : 18px;"> Kiểm tra cấm nhập
                                cảnh</div>
                        </div>
                    </button>
                </div>
            </div>
        @endif
        <div class="d-flex justify-content-center">
            <div class="homePage-side justify-content-center px-3 py-4" id="mostAccess-side">
                <h4 class="text-center homeSide-header" id="mostAccess-post-header">Bài viết được chú ý</h4>
                <div class="homeSide-scroll row d-block justify-content-center px-3 mostAccess-post-sec-unscroll"
                    id="mostAccess-posts-sec">
                    @foreach ($mostAccessPosts as $post)
                        @php
                            $avatarPath = 'storage/avatar-sample/ava1.jpg';
                            if ($post->user->user_avatar != null) {
                                $avatarPath = $post->user->user_avatar;
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
                                $postTimes = date('d/m/Y', strtotime($createdAt));
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
                                        {{ $post->user->name }}
                                    </p>
                                    <p class="newFeed-posterinfo-text">
                                        <span>{{ $postTimes }}</span>
                                        <span><i class="fa-solid fa-location-dot"></i> {{ $postAddress }}</span>
                                        <span class="newFeed-post-hashtag">
                                            {{ $postClassify }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            @if (sizeof($post->post_attachments) != 0)
                                <div style="padding:0px;" class="d-flex justify-content-center">
                                    <div class="swiper mySwiper">
                                        <div class="swiper-wrapper">
                                            @foreach ($post->post_attachments as $key => $attachment)
                                                <div class="swiper-slide ">
                                                    <img class="newFeed-image2"
                                                        src={{ $attachment->attachment_path }}>
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
                                    @for ($i = 1; $i < 6; $i++)
                                        <span
                                            class="fa fa-star @if ($i <= $post->rating_score) rating-star-checked @endif"></span>
                                    @endfor
                                </div>

                                <div class="newFeed-detail-icon">
                                    <span> {{ $post->access_times }} lượt truy cập</span>
                                </div>
                            </div>

                            <div class="row newFeed-content-small-sec2 "
                                onclick="accessPost('{{ route('post.mainPost', ['postId' => $post->id]) }}')">
                                <div class="row newFeed-info-title-sec2">
                                    <p class="newFeed-info-title2">{{ $post->title }}</p>
                                </div>
                                <div class="row newFeed-info-text-sec2">
                                    <p class="newFeed-info-text2">{!! nl2br($post->description) !!}</p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="row my-5 newfeed-sec" id="home-newFeed-sec">
                @foreach ($posts as $post)
                    @php
                        $avatarPath = 'storage/avatar-sample/ava1.jpg';
                        if ($post->user->user_avatar != null) {
                            $avatarPath = $post->user->user_avatar;
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
                            $postTimes = date('d/m/Y', strtotime($createdAt));
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
                                    {{ $post->user->name }}
                                </p>
                                <p class="newFeed-posterinfo-text">
                                    <span>{{ $postTimes }}</span>
                                    <span><i class="fa-solid fa-location-dot"></i> {{ $postAddress }}</span>
                                    <span class="newFeed-post-hashtag">
                                        {{ $postClassify }}
                                    </span>
                                </p>
                            </div>
                        </div>
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
                                @for ($i = 1; $i < 6; $i++)
                                    <span
                                        class="fa fa-star @if ($i <= $post->rating_score) rating-star-checked @endif"></span>
                                @endfor
                            </div>

                            <div class="newFeed-detail-icon">
                                <span id="newFeed-commentBtn-post-{{$post->id}}" onclick="openCommentSection({{ $post->id }})"> Đánh giá</span>
                            </div>

                            <div class="newFeed-detail-icon">
                                <span> {{ $post->access_times }} lượt truy cập</span>
                            </div>
                        </div>

                        <div class="row newFeed-content-small-sec2 "
                            onclick="accessPost('{{ route('post.mainPost', ['postId' => $post->id]) }}')">
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

                        <hr />
                        <div id="commentSec-post-{{$post->id}}" class="row justify-content-center mx-0 my-0" style="display:none;">
                            <div class="row d-block justify-content-center mx-0 my-2"
                                id="postComment-{{ $post->id }}">
                            </div>

                            <p style="display:none;" id="postComment-loadMore-forPost-{{$post->id}}" class="loadmore-cmt-btn">Xem thêm đánh giá</p>
                            <div class="row w-100 mx-0 my-1 justify-content-center" style="display:none;" id="postComment-noMoreComt-{{$post->id}}">
                                <p class="newFeed-detail-icon">Không có thêm đánh giá nào!</p>
                            </div>

                            @if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER) && Admin::user()->id != $post->user->id)
                                <div class="row w-100 mx-0 my-1 d-block justify-content-center">
                                    <h6 style="font-weight:600;">Viết đánh giá của bạn</h6>
                                    <div class="row w-100 mx-0 d-flex justify-content-center">

                                        <div class="row d-flex justify-content-center my-2 "
                                            style="width:100%; height:30px;">
                                            <i class="icon-global fa-solid fa-star fa-xl"
                                                id="post-{{ $post->id }}-commnentRating-1"
                                                onclick="commentRatingEvent({{ $post->id }}, 1)"
                                                style="width:auto; padding:0px; padding-top:12px;"></i>
                                            <i class="icon-global fa-solid  fa-star fa-xl"
                                                id="post-{{ $post->id }}-commnentRating-2"
                                                onclick="commentRatingEvent({{ $post->id }}, 2)"
                                                style="width:auto; padding:0px;padding-top:12px;"></i>
                                            <i class="icon-global fa-solid  fa-star fa-xl "
                                                id="post-{{ $post->id }}-commnentRating-3"
                                                onclick="commentRatingEvent({{ $post->id }}, 3)"
                                                style="width:auto; padding:0px; padding-top:12px;"></i>
                                            <i class="icon-global fa-solid  fa-star fa-xl"
                                                id="post-{{ $post->id }}-commnentRating-4"
                                                onclick="commentRatingEvent({{ $post->id }}, 4)"
                                                style="width:auto; padding:0px; padding-top:12px;"></i>
                                            <i class="icon-global fa-solid  fa-star fa-xl"
                                                id="post-{{ $post->id }}-commnentRating-5"
                                                onclick="commentRatingEvent({{ $post->id }}, 5)"
                                                style="width:auto; padding:0px; padding-top:12px;"></i>
                                        </div>

                                        <div style="width:100%; position:relative; height:60px;">
                                            <textarea id="post-{{ $post->id }}-commnentRating-comment" class="form-control"
                                                style="min-height : 50px; height: 60px; position: absolute; top:0px; left:0px; resize: none; overflow:auto;" value="">
                                            </textarea>

                                            <div class="row d-flex justify-content-center" style=" position: absolute; bottom:5px; right:20px;">
                                                <div class="comment-btn-sec">
                                                    <button class="comment-picbtn" disabled><i class="fa-solid fa-image"></i></button>
                                                    <input type="file" multiple="multiple"
                                                        name="post{{ $post->id }}CommentImg[]" placeholder="Choose image"
                                                        id="post-{{ $post->id }}-commentImg" class="comment-picbtn"
                                                        style="width:30px;" onchange="commentUploadImage({{ $post->id }})">
                                                </div>
                                                <button class="comment-sendCmtBtn" onclick="postSendComment({{ $post->id }})"><i class="fa-solid fa-paper-plane"></i></button>
                                            </div>

                                        </div>
                                        <p style="display:none;" id="post-{{ $post->id }}-commnentRating-val">
                                        </p>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <span class="text-danger"
                                            id="post-{{ $post->id }}-commentImg-warning"></span>
                                    </div>
                                    <div class="row d-flex justify-content-center"
                                        id="post-{{ $post->id }}-commentImg-preview-sec">
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="homePage-side justify-content-center px-3 py-4">
                <h4 class="text-center homeSide-header" id="ad-post-header">Quảng cáo</h4>
                <div class="homeSide-scroll row d-block justify-content-center px-3 mostAccess-post-sec-unscroll"
                    id="ad-posts-sec">
                    @foreach ($mostAccessPosts as $post)
                        @if (sizeof($post->post_attachments) != 0)
                            <div style="padding:0px;height : 200px;" class="d-flex justify-content-center">
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
                        <br><br>
                    @endforeach
                </div>
            </div>
        </div>


    </div>
    @include('templates.notification.toast');
    @include('templates.main.checkCarTicket');
    @include('templates.main.checkEntryBan');
    @include('templates.main.checkTaxDebt');
    @include('templates.main.checkAdminis');



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
            // console.log("Bottom of page");
        }

        var mostAccessPos = $('#mostAccess-side').offset().top - $(window).scrollTop();
        // console.log('test : ', mostAccessPos);
        if (mostAccessPos <= 70) {
            // console.log('abc');
            $('#mostAccess-post-header').addClass('mostAccess-post-header-scroll');
            $('#mostAccess-posts-sec').addClass('mostAccess-post-sec-scroll');
            $('#mostAccess-posts-sec').removeClass('mostAccess-post-sec-unscroll');


            $('#ad-post-header').addClass('mostAccess-post-header-scroll');
            $('#ad-posts-sec').addClass('mostAccess-post-sec-scroll');
            $('#ad-posts-sec').removeClass('mostAccess-post-sec-unscroll');
        } else {
            $('#mostAccess-post-header').removeClass('mostAccess-post-header-scroll');
            $('#mostAccess-posts-sec').addClass('mostAccess-post-sec-scroll');
            $('#mostAccess-posts-sec').removeClass('mostAccess-post-sec-unscroll');

            $('#ad-post-header').removeClass('mostAccess-post-header-scroll');
            $('#ad-posts-sec').addClass('mostAccess-post-sec-scroll');
            $('#ad-posts-sec').removeClass('mostAccess-post-sec-unscroll');



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

                        var isUser =  {{ Admin::user() !== null ? Admin::user()->isRole(ROLE_USER) : 0 }};
                        var writeCommentSec = '';
                        if(isUser==1){
                            var userId = {{ Admin::user() !== null?Admin::user()->id:0}};
                            if(userId!=0 && userId != e.ownerId){
                                writeCommentSec = `<div class="row w-100 mx-0 my-1 d-block justify-content-center">
                                                                        <h6 style="font-weight:600;">Viết đánh giá của bạn</h6>
                                                                        <div class="row w-100 mx-0 d-flex justify-content-center">

                                                                            <div class="row d-flex justify-content-center my-2 "
                                                                                style="width:100%; height:30px;">
                                                                                <i class="icon-global fa-solid fa-star fa-xl"
                                                                                    id="post-${e.id}-commnentRating-1"
                                                                                    onclick="commentRatingEvent(${e.id}, 1)"
                                                                                    style="width:auto; padding:0px; padding-top:12px;"></i>
                                                                                <i class="icon-global fa-solid  fa-star fa-xl"
                                                                                    id="post-${e.id}-commnentRating-2"
                                                                                    onclick="commentRatingEvent(${e.id}, 2)"
                                                                                    style="width:auto; padding:0px;padding-top:12px;"></i>
                                                                                <i class="icon-global fa-solid  fa-star fa-xl "
                                                                                    id="post-${e.id}-commnentRating-3"
                                                                                    onclick="commentRatingEvent(${e.id}, 3)"
                                                                                    style="width:auto; padding:0px; padding-top:12px;"></i>
                                                                                <i class="icon-global fa-solid  fa-star fa-xl"
                                                                                    id="post-${e.id}-commnentRating-4"
                                                                                    onclick="commentRatingEvent(${e.id}, 4)"
                                                                                    style="width:auto; padding:0px; padding-top:12px;"></i>
                                                                                <i class="icon-global fa-solid  fa-star fa-xl"
                                                                                    id="post-${e.id}-commnentRating-5"
                                                                                    onclick="commentRatingEvent(${e.id}, 5)"
                                                                                    style="width:auto; padding:0px; padding-top:12px;"></i>
                                                                            </div>
                                                                            <div style="width:100%; position:relative; height:60px;">
                                                                                <textarea id="post-${e.id}-commnentRating-comment" class="form-control"
                                                                                    style="min-height : 50px; height: 60px; position: absolute; top:0px; left:0px; resize: none; overflow:auto;" value="">
                                                                                </textarea>

                                                                                <div class="row d-flex justify-content-center" style=" position: absolute; bottom:5px; right:20px;">
                                                                                    <div class="comment-btn-sec">
                                                                                        <button class="comment-picbtn" disabled><i class="fa-solid fa-image"></i></button>
                                                                                        <input type="file" multiple="multiple"
                                                                                            name="post${e.id}CommentImg[]" placeholder="Choose image"
                                                                                            id="post-${e.id}-commentImg" class="comment-picbtn"
                                                                                            style="width:30px;" onchange="commentUploadImage(${e.id})">
                                                                                    </div>
                                                                                    <button class="comment-sendCmtBtn" onclick="postSendComment(${e.id})"><i class="fa-solid fa-paper-plane"></i></button>
                                                                                </div>

                                                                            </div>
                                                                            <p style="display:none;" id="post-${e.id}-commnentRating-val">
                                                                            </p>
                                                                        </div>
                                                                        <div class="row d-flex justify-content-center">
                                                                            <span class="text-danger"
                                                                                id="post-${e.id}-commentImg-warning"></span>
                                                                        </div>
                                                                        <div class="row d-flex justify-content-center"
                                                                            id="post-${e.id}-commentImg-preview-sec">
                                                                        </div>
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
                                                                    <span id="newFeed-commentBtn-post-${e.id}" onclick="openCommentSection(${e.id})"> Đánh giá</span>
                                                                </div>

                                                                <div class="newFeed-detail-icon">
                                                                    <span> ${e.accessTimes} lượt truy cập</span>
                                                                </div>
                                                            </div>

                                                            <div class="row newFeed-content-small-sec2" onclick="accessPost('${e.postLink}')">
                                                                <div class="row newFeed-info-title-sec2">
                                                                    <p class="newFeed-info-title2">${e.title}</p>
                                                                </div>
                                                                <div class="row newFeed-info-text-sec2">
                                                                    <p class="newFeed-info-text2">${e.description}</p>
                                                                </div>
                                                            </div>

                                                            ${likeIcon}

                                                            <hr />
                                                            <div id="commentSec-post-${e.id}" class="row justify-content-center mx-0 my-0" style="display:none;">
                                                                <div class="row d-block justify-content-center mx-0 my-2"
                                                                    id="postComment-${e.id}">
                                                                </div>

                                                                <p style="display:none;" id="postComment-loadMore-forPost-${e.id}" class="loadmore-cmt-btn">Xem thêm đánh giá</p>
                                                                <div class="row w-100 mx-0 my-1 justify-content-center" style="display:none;" id="postComment-noMoreComt-${e.id}">
                                                                    <p class="newFeed-detail-icon">Không có thêm đánh giá nào!</p>
                                                                </div>

                                                                ${writeCommentSec}
                                                            </div>
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

    function sendRequestChecking(data) {
        console.log(data);
        var url = "{{ route('check.addNew') }}";
        $.ajax({
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            data: data,
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if (data.error == 0) {
                    $('#toast-success-text').text(
                        'Gửi yêu cầu thành công. Vui lòng đợi phản hồi');
                    $('#notification-success').toast('show');
                } else {
                    $('#toast-fail-text').text('Có lỗi xảy ra, vui lòng thử lại');
                    $('#notification-fail').toast('show');
                }
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
            carTicketResetForms();
            carTicketResetFormStyle();
            $('#carTiket-modal').modal('show');
        })

        $('#checkAdministrative').on('click', function() {
            checkUserExist();
            adminisResetForms();
            adminisResetFormStyle();
            $('#adminis-modal').modal('show');
        })

        $('#checkTaxdebt').on('click', function() {
            checkUserExist();
            taxDebtResetForms();
            taxDebtResetFormStyle();
            $('#taxDebt-modal').modal('show');

        })

        $('#checkEntryBan').on('click', function() {
            checkUserExist();
            entryBanResetForms();
            entryBanResetFormStyle();
            $('#entryBan-modal').modal('show');
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
</script>

</html>
