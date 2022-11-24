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
<script type="text/javascript">
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

    function unlikePost(userId,postId, newFeedPostId){
        var url = "{{ route('post.postInteract.unlike') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                userId: userId,
                postId : postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    $(`#${newFeedPostId}`).empty();
                    $(`#${newFeedPostId}`).append(`<i class="fa-regular fa-heart"  onclick="likePost(${userId},${postId},'newFeed-post-${postId}' )"></i>`);
                }
            }

        });
    }

    function likePost(userId,postId, newFeedPostId){
        var url = "{{ route('post.postInteract.like') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                userId: userId,
                postId : postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    $(`#${newFeedPostId}`).empty();
                    $(`#${newFeedPostId}`).append(`<i style="color:red;" class="fa-solid fa-heart"  onclick="unlikePost(${userId},${postId},'newFeed-post-${postId}' )"></i>`);

                }
            }

        });
    }

    function deleteMyPost(postId, contentId){
        var url = "{{ route('post.deletePost') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                postId : postId,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.permission_allow == 0){
                    window.location.href = '{{route("home")}}'
                }else{
                    if(data.error == 0){
                        $(`#${contentId}`).remove();
                    }
                }
            }

        });
    }
</script>

<!-- Styles -->
<link href="{{ asset('css/app.css?v=') . time() }}" rel="stylesheet">
<link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
<link href="{{ asset('css/index.css?v=') . time() }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

