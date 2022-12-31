<!doctype html>
<html lang="vi">

@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
@endphp
<link href="{{ asset('css/mainScreen/index.css?v=') . time() }}" rel="stylesheet">
<link href="{{ asset('css/user/index.css?v=') . time() }}" rel="stylesheet">

<body class="bodyside">
    <div class="project-content-section">
        <div class="row d-block justify-content-center" style="width:100%; margin:0px;">
            <div class="row d-flex justify-content-center" style="width:100%; margin:0px; padding:0px; height:auto; background-color:white;">
                <div class = "user-main-sec">
                    <div class="user-image-sec d-flex justify-content-center" >
                        <div class="user-image-showing-sec " style="position:relative;">
                            <img id="accountUserAvatar" class="user-image-showing" src="{{asset($user->user_avatar)}}">
                            @if(Admin::user() !== null && Admin::user()->id == $userId)
                            <div class="row d-flex justify-content-center user-updateAvatar-sec" >
                                <div class="user-updateAvatar-showing-sec">
                                    <button class="user-updateAvatar" style="border:0px;" onclick="openAvatarModal()">
                                        <i class="fa-solid fa-camera-retro" style="color:black; "></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                    <div class="user-name-sec" style="position:relative;">
                        <div class="row user-name-text d-flex" style="width:calc(100%-20px); margin:0px;">
                            <h1 style="width:auto; font-weight: 800; color:black; font-size:25px;">{{$user->name}}</h1>
                        </div>
                    </div>
                    <div class="user-action-sec" style="position:relative;">
                        @if(Admin::user() !== null && Admin::user()->id == $userId)
                        <div class="row d-flex user-action-btn-sec" style="width:100%; margin:0px; padding:0px;">
                            <div style="width:auto;" class="user-edit-profile-btn" onclick="changeUserInfoBtn()">
                                <i class="fa-solid fa-pencil fa-xl"></i> <span class="user-edit-profile-btn-text">Chỉnh sửa thông tin cá nhân<span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center" style="width:100%; margin:0px; padding:0px; height:auto; background-color:white;">
                <div class = "user-main-sec d-block" style="margin:0px;">
                    <hr style="color:black; width:100%;"/>
                    <div class="row d-flex justify-content-start" style="width:100%;">
                        <div class="user-function-btn user-function-btn-active" id="postSelection">
                            Bài viết
                        </div>
                        @if(Admin::user() !== null && Admin::user()->id == $userId)
                        <div class="user-function-btn user-function-btn-inactive" id="settingSelection">
                            Cài đặt
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center" style="width:100%; margin:20px 0px;" id="userInfoPoint">
            <div class="user-main-sec " style="margin:0px; padding:0px;" id="userPosts">

                <div class="user-newfeed-leftside" id="userInfoLeft">
                    @if(isset($user->user_description) && $user->user_description!=null)
                    <div class="user-newfeed-info-sec">
                        <div class = "user-newfeed-info-common">
                            <h1 class="user-newfeed-info-title">Giới thiệu</h1>
                        </div>
                        @if(Admin::user() !== null && Admin::user()->id == $userId)
                        <div class = "user-newfeed-info-common">
                            <div style="width:100%;" class="user-edit-profile-btn d-flex justify-content-center" onclick="changeDescriptionBtn()">
                                <i class="fa-solid fa-pencil fa-xl icon-align"></i> <span class="user-edit-profile-btn-text">     Chỉnh sửa giới thiệu<span>
                            </div>
                        </div>
                        @endif

                        <div class="user-newfeed-info-common">
                            <h5>
                                {!!nl2br($user->user_description)!!}
                            </h5>
                        </div>
                    </div>
                    @endif

                    <div class="user-newfeed-info-sec">
                        <div class = "user-newfeed-info-common">
                            <h1 class="user-newfeed-info-title">Thông tin</h1>
                        </div>
                        @if(Admin::user() !== null && Admin::user()->id == $userId)
                        <div class = "user-newfeed-info-common">
                            <div style="width:100%;" class="user-edit-profile-btn d-flex justify-content-center" onclick="changeMainInfoBtn()">
                                <i class="fa-solid fa-pencil fa-xl icon-align"></i> <span class="user-edit-profile-btn-text">     Chỉnh sửa thông tin<span>
                            </div>
                        </div>
                        @endif

                        <div class="user-newfeed-info-common">
                            @if(isset($user->phone_number) && $user->phone_number!=null)
                            <div style="width:100%;" class="d-flex justify-content-center">
                                <h5 style="font-weight:700;">Số điện thoại:</h5>
                                <h5>{{$user->phone_number}}</h5>
                            </div>
                            @endif
                            <div style="width:100%;" class="d-flex justify-content-center">
                                <h5 style="font-weight:700;">Email:</h5>
                                <h5>{{$user->email}}</h5>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="user-newfeed-rightside">
                    @if(Admin::user() !== null && Admin::user()->id == $userId)
                    <div class = "user-newfeed-info-common" style="padding:0px;">
                        <div style="width:100%;" class="user-add-post-btn d-flex justify-content-center" onclick="gotoCreatePostPage()">
                            <i class="fa-solid fa-circle-plus  fa-xl" style="margin-top:10px;"></i> <span class="user-edit-profile-btn-text">&emsp;Đăng bài viết mới<span>
                        </div>
                    </div>
                    @endif
                    <div id="myPost-load" class="row newfeed-sec" style="padding:0px; margin : 10px 0px;">
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
                            <div class="row d-block justify-content-center newfeed-container2" id='myPost-{{ $post->id }}'>
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
                                    <div class="row d-flex justify-content-center" style="margin:10px 0px; padding:auto;">
                                        <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                                            id="newFeed-post-{{ $post->id }}" style="width : 33%; margin:auto;">
                                            @if ($post->checkPostLiked(Admin::user()->id, $post->id))
                                                <i style="color:red;" class="fa-solid fa-heart fa-xl interact-icon2"
                                                    onclick="unlikePost({{ Admin::user()->id }},{{ $post->id }},'newFeed-post-{{ $post->id }}' )"></i>
                                            @else
                                                <i class="fa-regular fa-heart fa-xl interact-icon2"
                                                    onclick="likePost({{ Admin::user()->id }},{{ $post->id }},'newFeed-post-{{ $post->id }}' )"></i>
                                            @endif
                                        </div>

                                        <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                                            style="width:33%; margin:auto;">
                                            <i class="fa-solid fa-pen-to-square fa-xl interact-icon2" style="color:#1d8daf"
                                                onclick="editPost('{{route('post.editPost',['postId'=>$post->id])}}')"></i>
                                        </div>

                                        <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                                            style="width:33%;margin:auto;">
                                            <i class="fa-solid fa-trash fa-xl interact-icon2"
                                                onclick="deleteMyPost({{ $post->id }},'myPost-{{ $post->id }}')"></i>
                                        </div>
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="user-main-sec" style="margin:0px; padding:0px; display:none;" id="userSettings">
                <div class="user-setting-section" id="userInfoLeft">
                    <div >
                        <div class = "user-newfeed-info-common">
                            <h1 class="user-newfeed-info-title">Mật khẩu</h1>
                        </div>
                        <div class = "user-newfeed-info-common">
                            <h6 class="user-setting-header">Đổi mật khẩu</h6>
                        </div>
                        <div class="row mb-3">
                            <label for="oldPassword" class="col-md-4 col-form-label text-md-end">Mật khẩu cũ</label>

                            <div class="col-md-6">
                                <input id="oldPassword" type="text" class="form-control @error('oldPassword') is-invalid @enderror" name="oldPassword" value="{{ old('oldPassword') }}" required autocomplete="oldPassword" autofocus>

                                {{-- @error('oldPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}

                                <span  class="invalid-feedback" role="alert">
                                    <strong id="oldPasswordWarning"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-form-label text-md-end">Mật khẩu mới</label>

                            <div class="col-md-6">
                                <input id="newPassword" type="text" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword" required autocomplete="current-password">

                                {{-- @error('newPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}

                                <span class="invalid-feedback" role="alert">
                                    <strong id="newPasswordWarning"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newPasswordConfirm" class="col-md-4 col-form-label text-md-end">Nhập lại mật khẩu mới</label>

                            <div class="col-md-6">
                                <input id="newPasswordConfirm" type="password" class="form-control @error('newPasswordConfirm') is-invalid @enderror" name="newPasswordConfirm" required autocomplete="current-password">

                                <span class="invalid-feedback" role="alert">
                                    <strong id="newPasswordConfirmWarning"></strong>
                                </span>
                            </div>
                        </div>
                        <div class = "d-flex justify-content-end" >
                            <button class="btn btn-primary normal-button" onclick="changePasswordBtn()">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>

        </div>

    </div>

    @include('templates.notification.toast');
    @include('user.templates.uploadAvatarModal');
    @include('user.templates.changeDescriptionModal');
    @include('user.templates.changeUserInfoModal');
    @include('user.templates.changeMainInfoModal');


</body>
<script>

    $(document).ready(function(){
        $('.user-function-btn').click(function(){
            let id = this.id;
            if(id =='postSelection' ){
                $('#postSelection').addClass('user-function-btn-active');
                $('#postSelection').removeClass('user-function-btn-inactive');
                $('#settingSelection').addClass('user-function-btn-inactive');
                $('#settingSelection').removeClass('user-function-btn-active');
                $('#userPosts').css('display', 'flex');
                $('#userSettings').css('display', 'none');

            }else if(id =='settingSelection' ){
                $('#settingSelection').addClass('user-function-btn-active');
                $('#settingSelection').removeClass('user-function-btn-inactive');
                $('#postSelection').addClass('user-function-btn-inactive');
                $('#postSelection').removeClass('user-function-btn-active');
                $('#userPosts').css('display', 'none');
                $('#userSettings').css('display', 'block');
            }
        });
    });
    var numberLoadingStep = 1;
    var allowLoad = true;
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

    function swiperReload() {
        swiper = new Swiper(`.mySwiper${numberLoadingStep-1}`, {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
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
                myPostLoadMoreData();
            }
            console.log("Bottom of page");
        }

        if(window.innerWidth>820){
            console.log('width big');

            var userInfoLeftPos = $('#userInfoPoint').offset().top - $(window).scrollTop();
            console.log('userInfoLeftPos : ', userInfoLeftPos);

            console.log('height to top : ', $(window).scrollTop());
            // console.log('test : ', mostAccessPos);
            if (userInfoLeftPos <= 70) {
                console.log('allow scroll');
                $('#userInfoLeft').css('margin-top',  $(window).scrollTop()-410);
            } else {
                console.log(' not allow scroll');

                $('#userInfoLeft').css('margin-top', 0);


            }
        }else{
            console.log('width small');
        }



    };

    function openAvatarModal(){
        console.log('avatar modal');
        $('#user-uploadAvatar').modal('show');
    }

    function changeDescriptionBtn(){
        $('#userDescriptionTextField').val(`{!!($user->user_description)!!}`);
        $('#user-uploadDescription').modal('show');
    }

    function changeUserInfoBtn(){
        console.log('changeUserInfoBtn');
        $('#userInfoDescription').val(`{!!($user->user_description)!!}`);

        // $('#userInfoAvatar').attr('src', '{{asset($user->user_avatar)}}');
        $('#user-uploadUserInfo').modal('show');

    }

    function changeMainInfoBtn(){
        console.log('changeMainInfoBtn');
        $('#userInfo-name').val('{{$user->name}}');
        $('#userInfo-phone').val('{{$user->phone_number}}');
        $('#user-uploadUserMainInfo').modal('show');
    }

    function gotoCreatePostPage(){
        window.location.href = '{{route("post.index")}}'
    }


    function changePasswordBtn(){
        var haveError =false;
        if($('#oldPassword').val() == ''){
            $('#oldPassword').addClass('is-invalid');
            $('#oldPasswordWarning').text('Mật khẩu cũ chưa được nhập');
            haveError=true;
        }else{
            $('#oldPassword').removeClass('is-invalid');
            $('#oldPasswordWarning').text('');
            haveError=false;
        }

        if($('#newPassword').val() == ''){
            $('#newPassword').addClass('is-invalid');
            $('#newPasswordWarning').text('Mật khẩu mới chưa được nhập');
            haveError=true;
        }else{
            let regex = new RegExp("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$");
            if(regex.test($('#newPassword').val())){
                $('#newPassword').removeClass('is-invalid');
                $('#newPasswordWarning').text('');
                haveError=false;
            }else{
                $('#newPassword').addClass('is-invalid');
                $('#newPasswordWarning').text('Mật khẩu mới phải bao gồm ký tự viết hoa, ký tự viết thường, số');
                haveError = true;
            }
        }

        if($('#newPasswordConfirm').val() == ''){
            $('#newPasswordConfirm').addClass('is-invalid');
            $('#newPasswordConfirmWarning').text('Mục này phải được nhập');
            haveError=true;
        }else{
            if($('#newPasswordConfirm').val() == $('#newPassword').val()){
                $('#newPasswordConfirm').removeClass('is-invalid');
                $('#newPasswordConfirmWarning').text('');
                haveError=false;
            }else{
                $('#newPasswordConfirm').addClass('is-invalid');
                $('#newPasswordConfirmWarning').text('Xác nhận mật khẩu không trùng khớp');
                haveError=true;
            }
        }

        if(!haveError){
            changePasswordRequest();
        }
    }

    function resetChangePasswordForm(){
        $('#oldPassword').val('');
        $('#oldPassword').removeClass('is-invalid');
        $('#oldPasswordWarning').text('');
        $('#newPassword').val('');
        $('#newPassword').removeClass('is-invalid');
        $('#newPasswordWarning').text('');
        $('#newPasswordConfirm').val('');
        $('#newPasswordConfirm').removeClass('is-invalid');
        $('#newPasswordConfirmWarning').text('');
    }

    function changePasswordRequest(){
        $.ajax({
            method: 'post',
            url: '{{ route('user.setting.changePassword') }}',
            data: {
                oldPassword: $('#oldPassword').val(),
                newPassword: $('#newPassword').val(),
                userId: {{ $userId }},
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.data.wrongOldPass == 1){
                    $('#oldPassword').addClass('is-invalid');
                    $('#oldPasswordWarning').text('Mật khẩu cũ không đúng');
                    $('#toast-fail-text').text('Đổi mật khẩu không thành công');
                    $('#notification-fail').toast('show');
                }else{
                    resetChangePasswordForm();
                    $('#toast-success-text').text(
                        'Đổi mật khẩu thành công');
                    $('#notification-success').toast('show');
                }
            }
        });
    }


    function myPostLoadMoreData() {
        $.ajax({
            method: 'post',
            url: '{{ route('post.myPost.loading') }}',
            data: {
                numberStep: numberLoadingStep,
                userId: {{ $userId }},
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                console.log('step: ', numberLoadingStep);

                if (data['error'] == 0) {
                    console.log('Data length : ', data.data.length);
                    data.data.forEach(function(e) {
                        var interactBtns = '';
                        if (e.isUser) {
                            var userId = {{ Admin::user() !== null ? Admin::user()->id : 0 }};
                            if (!e.liked) {
                                interactBtns = `<hr />
                                            <div class="row d-flex justify-content-center" style="margin:10px 0px; padding:auto;">
                                                <div class="row newFeed-interact-sec2 d-flex justify-content-center" id="newFeed-post-${e.id}" style="width : 33%; margin:auto;">
                                                    <i class="fa-regular fa-heart fa-xl interact-icon2" onclick="likePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>
                                                </div>
                                                <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                                                    style="width:33%; margin:auto;">
                                                    <i class="fa-solid fa-pen-to-square fa-xl interact-icon2" style="color:#1d8daf"
                                                        onclick="editPost('${e.postEditUrl}')"></i>
                                                </div>

                                                <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                                                    style="width:33%;margin:auto;">
                                                    <i class="fa-solid fa-trash fa-xl interact-icon2"
                                                        onclick="deleteMyPost(${e.id},'myPost-${e.id}')"></i>
                                                </div>
                                            </div>`;
                                // `<i class="fa-regular fa-heart" onclick="likePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>`;
                            } else {
                                interactBtns = `
                                            <hr />
                                            <div class="row d-flex justify-content-center" style="margin:10px 0px; padding:auto;">
                                                <div class="row newFeed-interact-sec2 d-flex justify-content-center" id="newFeed-post-${e.id}" style="width : 33%; margin:auto;">
                                                    <i style="color:red;" class="fa-solid fa-heart fa-xl interact-icon2" onclick="unlikePost(${userId},${e.id},'newFeed-post-${e.id}' )"></i>
                                                </div>
                                                <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                                                    style="width:33%; margin:auto;">
                                                    <i class="fa-solid fa-pen-to-square fa-xl interact-icon2" style="color:#1d8daf"
                                                        onclick="editPost('${e.postEditUrl}')"></i>
                                                </div>

                                                <div class="row newFeed-interact-sec2 d-flex justify-content-center"
                                                    style="width:33%;margin:auto;">
                                                    <i class="fa-solid fa-trash fa-xl interact-icon2"
                                                        onclick="deleteMyPost(${e.id},'myPost-${e.id}')"></i>
                                                </div>
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
                        $('#myPost-load').append(`<div class="row d-block justify-content-center newfeed-container2" id="myPost-${e.id}">
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

                                                            <div class="row newFeed-content-small-sec2 "  onclick="accessPost('${e.postLink}')">
                                                                <div class="row newFeed-info-title-sec2">
                                                                    <p class="newFeed-info-title2">${e.title}</p>
                                                                </div>
                                                                <div class="row newFeed-info-text-sec2">
                                                                    <p class="newFeed-info-text2">${e.description}</p>
                                                                </div>
                                                            </div>

                                                            ${interactBtns}
                                                            <hr />
                                                            <div id="commentSec-post-${e.id}" class="row justify-content-center mx-0 my-0" style="display:none;">
                                                                <div class="row d-block justify-content-center mx-0 my-2"
                                                                    id="postComment-${e.id}">
                                                                </div>

                                                                <p style="display:none;" id="postComment-loadMore-forPost-${e.id}" class="loadmore-cmt-btn">Xem thêm đánh giá</p>
                                                                <div class="row w-100 mx-0 my-1 justify-content-center" style="display:none;" id="postComment-noMoreComt-${e.id}">
                                                                    <p class="newFeed-detail-icon">Không có thêm đánh giá nào!</p>
                                                                </div>
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
</script>
</html>
