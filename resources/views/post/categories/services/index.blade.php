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
        <div class="row d-block justify-content-center" style="width:100%; margin:auto;">
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <h3 class="d-flex justify-content-center">
                    {{$header}}
                </h3>
            </div>
            <div class="row my-5 newfeed-sec" id="restaurant-newFeed-sec">
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
                                <span> Đánh giá</span>
                            </div>

                            <div class="newFeed-detail-icon">
                                <span> {{ $post->access_times }} lượt truy cập</span>
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



            </div>
        </div>
    </div>
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
            if (allowLoad) {
                allowLoad = false;
                newFeedLoadMoreData();
            }
        }
    };

    function newFeedLoadMoreData() {
        $.ajax({
            method: 'post',
            url: "{{ route('post.postCategory.service.loadMore',['classifyId'=>$classifyId]) }}",
            data: {
                numPage: numberLoadingStep,
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
                        $('#restaurant-newFeed-sec').append(`<div class="row d-block justify-content-center newfeed-container2">
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
</script>

</html>
