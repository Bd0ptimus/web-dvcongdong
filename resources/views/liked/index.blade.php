<!doctype html>
<html lang="vi">

@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
@endphp
{{-- <link href="{{ asset('css/mainScreen/index.css?v=') . time() }}" rel="stylesheet"> --}}
<link href="{{ asset('css/post/postLiked.css?v=') . time() }}" rel="stylesheet">

<body class="bodyside">
    <div class="project-content-section">
        <div class="row d-block justify-content-center" style="width:100%; margin:auto;">
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <h3 class="d-flex justify-content-center page-header" >
                    Những bài viết đã thích
                </h3>
            </div>


            <div class="row my-5 newfeed-sec" style="padding:0px;">
                @if (sizeof($posts) == 0)
                    <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                        <h6 class="d-flex justify-content-center">
                            Không có bài viết nào!
                        </h6>
                    </div>
                @endif

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
                    <div class="row d-block justify-content-center newfeed-container2" id="postLiked-{{$post->id}}">
                        <div class="row newFeed-content-small-sec2 d-flex justify-content-start">
                            <div class="newFeed-avatar-sec d-flex justify-content-start">
                                <div class="newFeed-avatar-container d-flex justify-content-center" onclick="openUserPage({{$post->user->id}})">
                                    <img class="newFeed-avatar" src={{ asset($avatarPath) }}>
                                </div>
                            </div>

                            <div class="newFeed-posterinfo-sec d-block justify-content-center">
                                <p class="newFeed-posterinfo-text" style="font-size : 17px; font-weight : 900;" onclick="openUserPage({{$post->user->id}})">
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

                        <div class="row newFeed-content-small-sec2 " onclick="accessPost('{{ route('post.mainPost', ['postId' => $post->id]) }}')">
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
                                        onclick="postLikedUnlike({{ $post->id }})"></i>
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
                            @if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER) &&Admin::user()->id != $post->user->id )
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
        </div>

    </div>
    @include('templates.notification.toast');

</body>

<script>
    let swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    function postLikedUnlike(postId) {
        var url = "{{ route('post.postInteract.unlike') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                userId: {{ Admin::user() !== null ? Admin::user()->id : null }},
                postId: postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if (data.error == 0) {
                    $(`#postLiked-${postId}`).remove();
                }
            }

        });
    }
</script>

</html>
