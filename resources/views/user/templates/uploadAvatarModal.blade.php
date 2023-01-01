@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="user-uploadAvatar" tabindex="-1" role="dialog"
    aria-labelledby="adminisModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center" style="position:relative;">
                <h4 style="font-size:20px; font-weight:bold; text-align:center; padding:0px 50px;">Thay đổi ảnh đại diện</h4>
                <span id="user-uploadAvatar-close" style=" position:absolute; right:10px; top:5px;"
                    class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align"></i></span>

            </div>


            <div class="modal-body">
                <main class="page">
                    <!-- input file -->
                    <div class="imgContainer d-block justify-content-center">
                        <div class="d-block justify-content-center" style="width:100%; ">
                            <div class="d-flex justify-content-center" style="width:100%;">
                                <img class="imgPreview" id="imgPreview" style="width : 200px; display:none;">
                            </div>
                        </div>

                        <br>
                        <div class="d-flex justify-content-center" style="width:100%;">
                            <div class="result" id="inputImg" style="width : 100%; max-width:500px; max-height:300px;"></div>
                        </div>

                        <div id="slider" class="ep-slider-bar"></div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <div class="upload-btn-wrapper">
                                <button class="normal-button" disabled><i
                                    class="fa-solid fa-camera-retro"></i>
                                Chọn ảnh đại diện</button>
                                <input type="file" id="file-input" class="normal-button" onchange="cropImgFunc(event)">
                            </div>
                        </div>
                    </div>
                </main>

                <button style="display:none;" id="changeAvatarSubmitBtn" class="normal-button" onclick="changeAvatarSubmit()">Thay đổi ảnh đại diện</button>
            </div>
        </div>
    </div>
    <style>
        #user-uploadAvatar{
            z-index:2001;
        }
        .page {
            margin: 1em auto;
            max-width: 768px;
            height: 100%;
        }

        .imgContainer {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .imgPreview {
            border-radius: 50%;
            margin-left: 20px;
        }

        .cropper-view-box {
            border-radius: 50%;
            outline: none;
        }

        .cropper-face.cropper-move {
            opacity: 0;
        }

        .ep-slider-bar {
            margin-top: 20px;
        }

        #adminisCheckingServiceBtn {
            background-color: #1d8daf;
            color: white;
            border: solid 1px #1d8daf;
        }

        #adminisCheckingServiceBtn:hover {
            border: solid 2px #1d8daf;
            transition: 0.5s;
            background-color: white;
            color: rgba(102, 102, 102, .85);
        }

        .modal-active {
            /* border-bottom: solid 3px #1d8daf; */
            color: white;
            background-color: #1d8daf;
            border-top-right-radius: 8px 8px;
            border-top-left-radius: 8px 8px;
        }

        .modalTitle {
            float: left;
            margin: 0px;
            padding: 10px 10px 0px;
        }

        .modalTitle:hover {
            transition: 0.4s;
            cursor: pointer;
            color: white;
            /* border-bottom: solid 3px #1d8daf; */
            background-color: #1d8daf;
            border-top-right-radius: 8px 8px;
            border-top-left-radius: 8px 8px;

        }

        .select2-dropdown {
            z-index: 2000;
        }


        @media screen and (min-width : 1020px) and (max-width: 5000px) {
            .modal-header {
                padding: 10px 20px 0px;
            }
        }


        @media screen and (min-width : 820px) and (max-width: 1020px) {
            .modal-header {
                padding: 10px 20px 0px;
            }
        }


        @media screen and (min-width : 450px) and (max-width: 820px) {
            .modal-header {
                padding: 10px 0px 10px 5px;
            }
        }


        @media screen and (max-width: 450px) {
            .modal-header {
                padding: 10px 0px 10px 5px;
            }
        }
    </style>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#user-uploadAvatar-close').on('click', function() {
            $('#user-uploadAvatar').modal('hide');
        })

        // $('#slider').on('mousemove vmousemove touchmove', function(){
        //     resetSlideBar();
        // });

    });

    let cropper = '';
    var newAvatar = '';
    function cropImgFunc(event) {
        let result = document.querySelector('#inputImg'),
            imgPreview = document.querySelector('#imgPreview');
        $('#changeAvatarSubmitBtn').css('display', 'block');
        if (event.target.files.length) {
            // start file reader
            const reader = new FileReader();
            reader.onload = function(event) {
                if (event.target.result) {
                    // create new image
                    let img = document.createElement('img');
                    img.id = 'image';
                    img.src = event.target.result;
                    img.width = 200;
                    img.height = 200;
                    // clean result before
                    result.innerHTML = '';
                    // append new image
                    result.appendChild(img);
                    // init cropper
                    cropper = new Cropper(img, {
                        viewMode: 1,
                        dragMode: 'move',
                        aspectRatio: 1,
                        autoCropArea: 0.8,
                        minContainerWidth: 200,
                        minContainerHeight: 200,
                        center: false,
                        zoomOnWheel: false,
                        zoomOnTouch: false,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        guides: false,
                        ready: function(event) {
                            this.cropper = cropper;
                        },
                        crop: function(event) {
                            let imgSrc = this.cropper.getCroppedCanvas({
                                width: 170,
                                height: 170 // input value
                            }).toDataURL("image/png");
                            imgPreview.src = imgSrc;
                            newAvatar = imgSrc;
                        }
                    });

                }
            };
            reader.readAsDataURL(event.target.files[0]);
            initSlideBar();
            resetSlideBar();
        }
    }

    function resetSlideBar() {
        slideValGlobal = 0.5;
        $("#slider").slider("value", slideValGlobal);
    }

    function initSlideBar() {
        let zoomRatio = 0;
        $("#slider").slider({
            range: "min",
            min: 0,
            max: 1,
            step: 0.01,
            slide: function(event, ui) {
                let slideVal = ui.value;
                let zoomRatio = Math.round((slideVal - slideValGlobal) * 100) / 100;
                slideValGlobal = slideVal;
                cropper.zoom(zoomRatio);
            }
        });
    };

    function changeAvatarSubmit(){
        let formData = new FormData();
        formData.append('changeAvatar', newAvatar);
        formData.append('userId', '{{$userId}}');

        console.log('form data : ', formData);

        $.ajax({
                type: 'post',
                url: "{{ route('user.setting.changeAvatar') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('respose success', response);
                    if(response.error == 0){
                        // $('#accountUserAvatar').attr('src', response.data);
                        // $('#user-uploadAvatar').modal('hide');
                        window.location.reload();
                    }
                },
                error: function(response) {

                }
            });
    }
</script>
