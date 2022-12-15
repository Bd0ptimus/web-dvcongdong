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
        <div class="row mainPost-main d-flex justify-content-center" style=" padding:0px; margin-bottom:50px;">
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
                        <div style="padding:0px; width: 100%;" class="d-flex justify-content-center">
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

                <div class="row newFeed-content-small-sec2 d-flex justify-content-around w-100">
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
                            <div class="userInfo-sec d-block justify-content-center" style="margin:0px;">
                                <h5 style="font-weight : 600;">{{ $post->user->name }}</h5>
                                <div class="userInfo-text">
                                    <i class="fa-solid fa-clock"></i> {{ $postTimes }}
                                </div>
                                <div class="userInfo-text">
                                    <i class="fa-solid fa-location-dot"></i> {{ $postAddress }}
                                </div>
                                <div class="userInfo-text">
                                    Ngày hết hạn : {{ date('d/m/Y', strtotime($post->exist_to)) }}
                                </div>
                            </div>
                        </div>
                        <div class="mainPost-contact-sec">
                            @if (isset($post->user->phone_number))
                                <div class="d-flex justify-content-center">
                                    <div class="contactInfo-sec">
                                        <i class="fa-solid fa-phone"></i> {{ $post->user->phone_number }}
                                    </div>
                                </div>
                                @if ($post->contact_phone_number)
                                    <div class="d-flex justify-content-center">
                                        <div class="contactInfo-sec">
                                            <i class="fa-solid fa-phone"></i> {{ $post->contact_phone_number }}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="d-flex justify-content-center">
                                    <div class="contactInfo-sec">
                                        <i class="fa-solid fa-phone"></i> {{ $post->contact_phone_number }}
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-center">
                                <div class="contactInfo-sec">
                                    <i class="fa-solid fa-envelope"></i> {{ $post->user->email }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 style="font-weight:600;">Đánh giá</h6>
                <div class="row d-block justify-content-center mx-0 my-2" id="postComment-{{ $post->id }}">
                </div>


                <p style="display:none;" id="postComment-loadMore-forPost-{{ $post->id }}"
                    class="loadmore-cmt-btn">Xem thêm đánh giá</p>
                <div class="row w-100 mx-0 my-1 justify-content-center" style="display:none;"
                    id="postComment-noMoreComt-{{ $post->id }}">
                    <p class="newFeed-detail-icon">Không có thêm đánh giá nào!</p>
                </div>
                @if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER) && Admin::user()->id != $post->user->id)
                    <div class="row w-100 mx-0 my-5 d-block justify-content-center">
                        <h6 style="font-weight:600;">Viết đánh giá của bạn</h6>
                        <div class="row w-100 mx-0 d-flex justify-content-center">

                            <div class="row d-flex justify-content-center my-2 " style="width:100%; height:30px;">
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
                                    style="min-height : 50px; height: 60px; position: absolute; top:0px; left:0px; resize: none; overflow:auto;"
                                    value="">
                                            </textarea>

                                <div class="row d-flex justify-content-center"
                                    style=" position: absolute; bottom:5px; right:20px;">
                                    <div class="comment-btn-sec">
                                        <button class="comment-picbtn" disabled><i
                                                class="fa-solid fa-image"></i></button>
                                        <input type="file" multiple="multiple"
                                            name="post{{ $post->id }}CommentImg[]" placeholder="Choose image"
                                            id="post-{{ $post->id }}-commentImg" class="comment-picbtn"
                                            style="width:30px;" onchange="commentUploadImage({{ $post->id }})">
                                    </div>
                                    <button class="comment-sendCmtBtn"
                                        onclick="postSendComment({{ $post->id }})"><i
                                            class="fa-solid fa-paper-plane"></i></button>
                                </div>

                            </div>
                            <p style="display:none;" id="post-{{ $post->id }}-commnentRating-val">
                            </p>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <span class="text-danger" id="post-{{ $post->id }}-commentImg-warning"></span>
                        </div>
                        <div class="row d-flex justify-content-center"
                            id="post-{{ $post->id }}-commentImg-preview-sec">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('templates.notification.toast');

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

    $(document).ready(function(){
        loadCommentOfPost({{$post->id}},0);
    });
</script>

</html>
