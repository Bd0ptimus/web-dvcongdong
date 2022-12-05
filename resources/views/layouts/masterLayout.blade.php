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
                        `<i class="fa-regular fa-heart fa-xl interact-icon2"  onclick="likePost(${userId},${postId},'newFeed-post-${postId}' )"></i>`
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
                        `<i style="color:red;" class="fa-solid fa-heart fa-xl interact-icon2"  onclick="unlikePost(${userId},${postId},'newFeed-post-${postId}' )"></i>`
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
                            $('#citySelectionSearch').append(`<option value="${e.id}">${e.city}</option>`);
                        })
                    }
                }

            });
        }
    });
</script>
{{-- @extends('templates.main.mainCheckingService') --}}


<!-- Styles -->
<link href="{{ asset('css/app.css?v=') . time() }}" rel="stylesheet">
<link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
<link href="{{ asset('css/index.css?v=') . time() }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
