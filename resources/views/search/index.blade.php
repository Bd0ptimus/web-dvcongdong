<!doctype html>
<html lang="vi">
@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
@endphp
<link href="{{ asset('css/post/chooseTopic.css?v=') . time() }}" rel="stylesheet">
<link href="{{ asset('css/search/index.css?v=') . time() }}" rel="stylesheet">

<body>
    <div class="project-content-section ">
        <div class="row chooseTopic-main d-flex justify-content-center">
            <div class="row chooseTopic-header-sec" style="width: 100%; padding:20px 0px;">
                <h3 class="chooseTopic-header chooseTopic-text">
                    Tìm kiếm
                </h3>
            </div>

            <div id="searchFilterSection" class="row justify-content-center" style="width: 100%; padding:15px 0px;">
                <form id="frm-search-job" action="{{ route('search.homeSearch') }}" method="POST">@csrf
                    <div class="" id="searchFilter">
                        <div id="searchKeyWord" class="form-group input-data vertical-container d-flex justify-content-center" style="height : 48px;">
                            <input autocomplete="off"
                                class="form-control form-control-input-text ui-autocomplete-input vertical-element-middle-align"
                                id="Filter_Keyword" name="homeFilterKeyWord" placeholder="Từ khóa" type="text"
                                style="height: 46px; width:100%" value="{{$keywordChoosen}}">
                        </div>
                        <div class="form-group input-data">
                            <select class="search-filter-classify" name="homeFilterClassify">
                                <option value="0">Tất cả</option>
                                @foreach ($classifies as $classify)
                                    <option value="{{ $classify->id }}" @if($classify->id == $classifyChoosen) selected @endif>{{ $classify->classify_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group input-data">
                            <select class="search-filter-position" name="homeFilterPosition">
                                <option value="0">Toàn Nga</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @if($city->id == $positionChoosen) selected @endif>{{ $city->city }}</option>
                                @endforeach

                            </select>
                        </div>
                        <br>
                        <div class="search-submit input-data vertical-container" style=" height : 48px; margin: 10px 0px;">
                            <button
                                class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn bg-white"
                                type="submit" style="height: 46px; margin:auto; padding : 0px; width: 100%;">
                                <i class="fa fa-search"></i><span> Tìm kiếm</span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>


        </div>
        <div class="row my-5 newfeed-sec" id="search-newFeed-sec">
            @foreach ($posts as $post)
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
                                        {{-- <i style="color:red;" class="fa-solid fa-heart"></i> --}}
                                    </span>
                                @endif
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
    @include('templates.main.mainCheckingService')

</body>

<script>
    function formatTextClassify(icon) {
        return $('<span><i class="fa-solid fa-bars"></i>     ' + icon.text + '</span>');
    };
    $('.search-filter-classify').select2({
        width: "100%",
        placeholder: 'Phân loại',
        templateSelection: formatTextClassify,
        selectionCssClass: 'header-function-sec',
    });


    function formatTextPosition(icon) {
        return $('<span><i class="fas fa-map-marker-alt"></i>     ' + icon.text + '</span>');
    };
    $('.search-filter-position').select2({
        width: "100%",
        placeholder: 'Vị trí',
        templateSelection: formatTextPosition,
        selectionCssClass: 'header-function-sec',
    });


    var numberLoadingStep = 1;
    var allowLoad = true;
    window.onscroll = function(ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
            // you're at the bottom of the page
            if(allowLoad){
                allowLoad=false;
                newFeedLoadMoreData();
            }
            console.log("Bottom of page");
        }
    };

    function newFeedLoadMoreData() {
        $.ajax({
            method: 'post',
            url: '{{ route('search.searchResultLoading') }}',
            data: {
                keyword :'<?=$keywordChoosen?>',
                classify :<?=$classifyChoosen?>,
                position :<?=$positionChoosen?>,
                numberStep: numberLoadingStep,
                userId: {{ Admin::user() !== null ? Admin::user()->id : 0 }},
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response in search loadmore: ', JSON.stringify(data));
                console.log('step: ',numberLoadingStep);

                if (data['error'] == 0) {
                    console.log('Data length : ',data.data.length);
                    data.data.forEach(function(e){
                        var likeIcon = '';
                        if (e.isUser) {
                            var userId = {{ Admin::user() !== null ? Admin::user()->id : 0 }};
                            if (!e.liked) {
                                likeIcon =
                                    `<i class="fa-regular fa-heart" onclick="likePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>`;
                            } else {
                                likeIcon = `<i style="color:red;" class="fa-solid fa-heart" onclick="unlikePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>`;
                            }
                        }
                        $('#search-newFeed-sec').append(`<div class="row newfeed-container d-flex justify-content-center">
                                                            <div class="row newfeed-content-sec">
                                                                <div class="newfeed-image-sec  newFeed-image-sec">
                                                                    <img class="newFeed-image" src="${e.image}">

                                                                </div>

                                                                <div class="newfeed-info-sec d-block justify-content-center">
                                                                    <div class="row newFeed-interact-sec d-flex justify-content-end">
                                                                        <span class="newFeed-icon-sec" id="newFeed-post-${e.id}">
                                                                            ${likeIcon}
                                                                        </span>
                                                                    </div>
                                                                    <div class="row newFeed-info-title-sec vertical-container">
                                                                        <p class="newFeed-info-title vertical-element-middle-align">${e.title}</p>
                                                                    </div>
                                                                    <div class="row newFeed-info-content-sec">
                                                                        <div class="row newFeed-info-description-sec vertical-container">
                                                                            <p class="newFeed-info-description vertical-element-middle-align">
                                                                                ${e.description}</p>
                                                                        </div>
                                                                        <div class="row newFeed-info-detail-sec">
                                                                            <div class="newFeed-detail-icon">
                                                                                <i class="fa-solid fa-location-dot"></i><span> ${e.address}</span>
                                                                            </div>

                                                                            <div class="newFeed-detail-icon">
                                                                                <i class="fa-solid fa-bars"></i><span> ${e.classify}</span>
                                                                            </div>

                                                                            <div class="newFeed-detail-icon">
                                                                                <i class="fa-solid fa-clock"></i><span> ${e.times}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>`);
                    })
                    if(data.data.length> 0){
                        numberLoadingStep++;
                    }
                }
                allowLoad=true;
            }

        });
    }
</script>

</html>
