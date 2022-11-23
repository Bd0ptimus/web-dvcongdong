<!doctype html>
<html>

@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
@endphp
{{-- <link href="{{ asset('css/mainScreen/index.css?v=') . time() }}" rel="stylesheet"> --}}
<link href="{{ asset('css/post/postLiked.css?v=') . time() }}" rel="stylesheet">

<body style="position:relative;">
    <div class="project-content-section" >
        <div class="row d-block justify-content-center" style="width:100%; margin:auto;">
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <h3 class="d-flex justify-content-center">
                    Những bài viết đã thích
                </h3>
            </div>


            <div class="row my-5 newfeed-sec" style="padding:0px;">
                @if(sizeof($posts) == 0)
                    <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                        <h6 class="d-flex justify-content-center">
                            Không có bài viết nào!
                        </h6>
                    </div>
                @endif
                @foreach ($posts as $post)
                    <div class="row newfeed-container d-flex justify-content-center" id="postLiked-{{$post->id}}">
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
                                    <a class="postLiked-unlike-btn" onclick="postLikedUnlike({{$post->id}})">Bỏ thích</a>
                                </div>
                                <div class="row newFeed-info-title-sec vertical-container">
                                    <p class="newFeed-info-title vertical-element-middle-align">{{ $post->title }}</p>
                                </div>
                                <div class="row newFeed-info-content-sec">
                                    <div class="row newFeed-info-description-sec vertical-container">
                                        <p class="newFeed-info-description vertical-element-middle-align">
                                            {{ $post->description }}</p>
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
                @endforeach
            </div>
        </div>

    </div>
</body>

<script>
    function postLikedUnlike(postId){
        var url = "{{ route('post.postInteract.unlike') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                userId: {{Admin::user()!==null?Admin::user()->id:null}},
                postId : postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    $(`#postLiked-${postId}`).remove();
                }
            }

        });
    }
</script>
</html>
