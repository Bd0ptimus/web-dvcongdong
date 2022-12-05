<!doctype html>
<html lang="vi">

@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
@endphp
<link href="{{ asset('css/post/mainPost.css?v=') . time() }}" rel="stylesheet">
<link href="{{ asset('css/post/newPostCreate.css?v=') . time() }}" rel="stylesheet">

<body>
    <div class="project-content-section d-flex justify-content-center">
        <div class="row newPost-main d-flex justify-content-center" style="width: 80%; padding:0px; margin-bottom:50px;">
            <div class="row newPost-header-sec" style="width: 100%; padding:20px 0px;">
                <h3 class="newPost-header newPost-text">
                    {{ $post->title }}
                </h3>
            </div>

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

            <div class="row d-flex justify-content-center" style="width: 100%; padding:15px 0px;">
                <div class="row d-flex justify-content-center">
                    @if (sizeof($post->post_attachments) != 0)
                        <div style="padding:0px; width: 60%;" class="d-flex justify-content-center">
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
                </div>

                <div class="row d-flex justify-content-center mainPost-content-section">
                    <div class="mainPost-content-title">
                        Mô tả
                    </div>
                    <br>
                    <div>
                        {!! nl2br($post->description) !!}
                    </div>
                </div>

                <div class="row d-flex justify-content-center mainPost-content-section">
                    <div class="mainPost-content-title">
                        Thông Tin Liên Hệ
                    </div>
                    <br>
                    <div class="mainPost-contact-info" style="width:100%;">
                        <div class="mainPost-contact-sec d-flex justify-content-start">
                            <div class="avatar-sec">
                                <img class="mainPost-avatar" src={{ asset($avatarPath) }}>
                            </div>
                            <div class ="userInfo-sec d-block justify-content-center" style="margin:0px;">
                                <h5 style="font-weight : 600;">{{$post->user->name}}</h5>
                                <div class="userInfo-text">
                                    <i class="fa-solid fa-clock"></i> {{$postTimes}}
                                </div>
                                <div class="userInfo-text">
                                    <i class="fa-solid fa-location-dot"></i> {{$postAddress}}
                                </div>
                                <div class="userInfo-text">
                                    Ngày hết hạn :  {{date('d/m/Y', strtotime($post->exist_to))}}
                                </div>
                            </div>
                        </div>
                        <div class="mainPost-contact-sec" >
                            @if(isset($post->user->phone_number))
                                <div class="d-flex justify-content-center">
                                    <div  class="contactInfo-sec">
                                        <i class="fa-solid fa-phone"></i> {{$post->user->phone_number}}
                                    </div>
                                </div>
                                @if($post->contact_phone_number)
                                    <div class="d-flex justify-content-center">
                                        <div  class="contactInfo-sec">
                                            <i class="fa-solid fa-phone"></i> {{$post->contact_phone_number}}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="d-flex justify-content-center">
                                    <div  class="contactInfo-sec">
                                        <i class="fa-solid fa-phone"></i> {{$post->contact_phone_number}}
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-center">
                                <div  class="contactInfo-sec">
                                    <i class="fa-solid fa-envelope"></i> {{$post->user->email}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    var numberLoadingStep = 1;
    let swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>

</html>
