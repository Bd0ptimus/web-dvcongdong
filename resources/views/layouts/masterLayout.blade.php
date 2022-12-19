<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Nguoiviettainga') }}</title>
@php
    use App\Admin;
@endphp
<!-- Scripts -->
<script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script src="https://kit.fontawesome.com/04e9a3dbb4.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script type="text/javascript">
    function checkUserExist() {
        var userId = '<?= Admin::user() !== null ? Admin::user()->id : null ?>';
        if (userId == '') {
            window.location.href = '{{ route('warning.accountRequire') }}'
            die();
        }
    }

    function removePreviewImage(idForRemove, inputId) {
        document.getElementById(`${inputId}`).value = "";
        // var file = document.getElementById('logoUpload').value;
        // console.log("check file exists: " + file);
        $(`#${idForRemove}`).empty();
    }

    function setButtonActiveDisabled(control, id) {
        console.log('in set btn active');
        //control 0: active-1: disabled
        if (control == 0) {
            $(`#${id}`).removeClass('button-disabled');
            $(`#${id}`).addClass('button-active');
            $(`#${id}`).removeAttr("disabled");
        } else {
            $(`#${id}`).removeClass('button-active');
            $(`#${id}`).addClass('button-disabled');
            $(`#${id}`).attr("disabled", true);

        }
    }

    function unlikePost(userId, postId, newFeedPostId) {
        var url = "{{ route('post.postInteract.unlike') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                userId: userId,
                postId: postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if (data.error == 0) {
                    $(`#${newFeedPostId}`).empty();
                    $(`#${newFeedPostId}`).append(
                        `<i class="fa-regular fa-heart fa-xl interact-icon2 icon-align"  onclick="likePost(${userId},${postId},'newFeed-post-${postId}' )"></i>`
                    );
                }
            }

        });
    }

    function likePost(userId, postId, newFeedPostId) {
        var url = "{{ route('post.postInteract.like') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                userId: userId,
                postId: postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if (data.error == 0) {
                    $(`#${newFeedPostId}`).empty();
                    $(`#${newFeedPostId}`).append(
                        `<i style="color:red;" class="fa-solid fa-heart fa-xl interact-icon2 icon-align"  onclick="unlikePost(${userId},${postId},'newFeed-post-${postId}' )"></i>`
                    );

                }
            }

        });
    }

    function deleteMyPost(postId, contentId) {
        var url = "{{ route('post.deletePost') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                postId: postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if (data.permission_allow == 0) {
                    window.location.href = '{{ route('home') }}'
                } else {
                    if (data.error == 0) {
                        $(`#${contentId}`).remove();
                    }
                }
            }

        });
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function accessPost(postLink){
        window.location.href = postLink;
    }

    function loadComment(elementId, step){

    }

    function commentRatingEvent(postId, commentRatingStar){
        for(var i=1; i<=5; i++){
            $(`#post-${postId}-commnentRating-${i}`).removeClass('rating-star-checked');
        }
        for(var i=1; i<=commentRatingStar; i++){
            $(`#post-${postId}-commnentRating-${i}`).addClass('rating-star-checked');
        }

        $(`#post-${postId}-commnentRating-val`).text(commentRatingStar);
    }


    var commentPhotos=[];
    function commentUploadImage(postId){
        var filesTypesAccept = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
            // var files = $(`#post-${postId}-commentImg`).files;
            var files = document.getElementById(`post-${postId}-commentImg`).files;
            var filesAmount = files.length;
            console.log('file amount : ', files);

            $(`#post-${postId}-commentImg-preview-sec`).empty();
            for (let i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                var extension = files[i].name.split('.').pop().toLowerCase();
                fileExtensionAccept = filesTypesAccept.indexOf(extension) > -1;
                if (fileExtensionAccept) {
                    fileSizeAccept = files[i].size < 15728640;
                    if (fileSizeAccept) {

                        try{
                            commentPhotos[postId].items.add(files[i]);
                        }catch(error){
                            commentPhotos[postId]=new DataTransfer();
                            commentPhotos[postId].items.add(files[i]);
                        }

                        $(`#post-${postId}-commentImg-warning`).text('');
                    } else {
                        $(`#post-${postId}-commentImg-warning`).text(
                            'Kích thước ảnh quá lớn! Mỗi ảnh được chọn phải có kích thước không lớn hơn 15mb.'
                        );
                    }
                } else {
                    $(`#post-${postId}-commentImg-warning`).text(
                        'Định dạng file không được chấp nhận! Chỉ chấp nhận ảnh JPG, JPEG, PNG, GIF, AVG.'
                    );
                }
            }

            console.log('check files : ', commentPhotos[postId]);
            const input = document.getElementById(`post-${postId}-commentImg`);

            input.files = commentPhotos[postId].files;
            var filesAdd = $(`#post-${postId}-commentImg`).prop('files');
            for (let i = 0; i < filesAdd.length; i++) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    console.log('check file multiple: ', i);
                    $(`#post-${postId}-commentImg-preview-sec`).append(`
                            <div class="preview-image-sec" >
                                <img class="upload-image" src="${e.target.result}" alt="logo upload">
                                <i class="previewImage-delete-icon fa-solid fa-square-xmark fa-xl" onclick="removeCommentPreviewImg(${postId},${i}, 'post-${postId}-commentImg-preview-sec', 'post-${postId}-commentImg')"></i>
                            </div>
                        `);
                }
                reader.readAsDataURL(filesAdd[i]);
            }
    }

    function removeCommentPreviewImg(postId, index, idForRemove, inputId){
        commentPhotos[postId] = new DataTransfer();
        const input = document.getElementById(inputId)
        const {
            files
        } = input

        console.log('index for remove : ', index);
        for (let i = 0; i < files.length; i++) {
            const file = files[i]
            if (index !== i) {
                console.log('not remove i : ', i);
                commentPhotos[postId].items.add(file) // here you exclude the file. thus removing it.
            }
        }
        input.files = commentPhotos[postId].files;
        // desPhotoExist.files = dt.files;
        $(`#${idForRemove}`).empty();

        var newListFiles = $(`#${inputId}`).prop('files');
        for (let i = 0; i < newListFiles.length; i++) {
            let reader = new FileReader();

            reader.onload = (e) => {
                console.log('check file multiple: ', i);
                $(`#${idForRemove}`).append(`
                            <div class="preview-image-sec">
                                <img class="upload-image" src="${e.target.result}" alt="logo upload">
                                <i class="previewImage-delete-icon fa-solid fa-square-xmark fa-xl" onclick="removeCommentPreviewImg(${postId},${i}, '${idForRemove}', '${inputId}')"></i>
                            </div>
                        `);
            }
            reader.readAsDataURL(newListFiles[i]);
        }
    }

    function postSendComment(postId){

        if($(`#post-${postId}-commnentRating-comment`).val().trim().length == ''){
            $(`#post-${postId}-commnentRating-comment`).addClass('form-warning');
            return;
        }else{
            $(`#post-${postId}-commnentRating-comment`).removeClass('form-warning');
        }


        var url = "{{ route('post.comment.uploadComment') }}";

        var formData = new FormData();
        let TotalFiles = $(`#post-${postId}-commentImg`)[0].files.length; //Total files
        let files = $(`#post-${postId}-commentImg`)[0];
        for (let i = 0; i < TotalFiles; i++) {
            formData.append('files' + i, files.files[i]);
        }
        formData.append('TotalFiles', TotalFiles);
        formData.append('userId', '<?= Admin::user() !== null ? Admin::user()->id : null ?>');
        formData.append('postId', postId);
        formData.append('postCommentText', $(`#post-${postId}-commnentRating-comment`).val());
        formData.append('postRating',  $(`#post-${postId}-commnentRating-val`).text());

        console.log('form data : ', formData);
        $.ajax({
            method: 'post',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    reloadCommentSec(postId);
                    $('#toast-success-text').text(
                        'Gửi đánh giá thành công!');
                    $('#notification-success').toast('show');
                }else{
                    $('#toast-fail-text').text('Có lỗi xảy ra, vui lòng thử lại');
                    $('#notification-fail').toast('show');
                }
            }

        });
    }

    function reloadCommentSec(postId){
        $(`#post-${postId}-commnentRating-val`).text('');
        $(`#post-${postId}-commnentRating-comment`).val('');
        for(var i=1; i<=5; i++){
            $(`#post-${postId}-commnentRating-${i}`).removeClass('rating-star-checked');
        }
        $(`#post-${postId}-commentImg-preview-sec`).empty();
        $(`#post-${postId}-commentImg-warning`).text('');

    }

    function watchImageModal(url){
        $('#imgShow-modal-img').attr('src',url)
        $('#imgShow-modal').modal('show');
    }


    function loadCommentOfPost(postId, step){
        console.log('load loadCommentOfPost');
        var url = "{{ route('post.comment.loadComment') }}";
        $.ajax({
            method: 'get',
            url: url,
            data: {
                postId: postId,
                step:step,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    data.data.commentsInterface.forEach(function(comment){
                        $(`#postComment-${postId}`).append(comment);
                    });
                    if(data.data.hasNextComments==true){
                        loadMoreBtnControl( postId, data.data.nextStep);
                    }else{
                        $(`#postComment-loadMore-forPost-${postId}`).removeClass('d-block');
                        $(`#postComment-noMoreComt-${postId}`).addClass('d-flex');

                    }
                }
            }

        });
    }

    function loadMoreBtnControl( postId, nextStep){
        $(`#postComment-loadMore-forPost-${postId}`).attr('onclick', `loadCommentOfPost(${postId}, ${nextStep})`);
        $(`#postComment-loadMore-forPost-${postId}`).addClass('d-block');
        $(`#postComment-noMoreComt-${postId}`).removeClass('d-flex');

    }

    function openCommentSection(postId){
        console.log('in openCommentSection');
        if($(`#commentSec-post-${postId}`).css('display') == 'block'){
            console.log('inblock');
            $(`#commentSec-post-${postId}`).css('display', 'none');
            $(`#postComment-${postId}`).empty();
            reloadCommentSec(postId);
            $(`#newFeed-commentBtn-post-${postId}`).removeClass('text-bold');

        }else{
            console.log('outblock');

            $(`#commentSec-post-${postId}`).css('display', 'block');
            $(`#newFeed-commentBtn-post-${postId}`).addClass('text-bold');
            loadCommentOfPost(postId, 0);
        }
    }

    $(document).ready(function() {
        var citiesCookies =  '<?=Cookie::get('nguoiviettainga-cities')?>';
        if (citiesCookies == '') {
            $.ajax({
                method: 'get',
                url: '{{route('getCities')}}',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    if(data.data.cookies_existed == false){
                        data.data.cities.forEach(function(e){
                            $('#citySelectionSearch-pc-tb').append(`<option value="${e.id}">${e.city}</option>`);
                        })
                    }
                }

            });
        }
    });
</script>
@extends('templates.imageShow')


<!-- Styles -->
<link href="{{ asset('css/app.css?v=') . time() }}" rel="stylesheet">
<link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
<link href="{{ asset('css/index.css?v=') . time() }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
