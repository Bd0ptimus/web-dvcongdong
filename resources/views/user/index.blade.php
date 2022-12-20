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
    <div class="row d-block justify-content-center" style="width:100%; margin:0px;">
        <div class="row d-flex justify-content-center" style="width:100%; margin:0px; padding:0px; height:auto; background-color:white;">
            <div class = "user-main-sec">
                <div class="user-image-sec d-flex justify-content-center" style="position:relative;">
                    <div class="user-image-showing-sec ">
                        <img class="user-image-showing" src="{{asset('storage/test/test1.jpg')}}">
                    </div>
                    <div class="row d-flex justify-content-center user-updateAvatar-sec" >
                        <div class="user-updateAvatar-showing-sec">
                            <button class="user-updateAvatar" disabled>
                                <i class="fa-solid fa-camera-retro" style="color:black;"></i>
                            </button>
                            <input type="file" name="logoUpload"
                                placeholder="Choose image" id="logoUpload"
                                class="user-updateAvatar" style=" margin:0px 12px;">
                        </div>
                    </div>
                </div>
                <div class="user-name-sec" >
                    <div class="row user-name-text d-flex" style="width:calc(100%-20px); margin:0px 10px;">
                        <h1 style="width:auto;">Bùi Dũng</h1>
                    </div>
                </div>
                <div class="user-action-sec">

                </div>
            </div>
        </div>
    </div>
</body>

</html>
