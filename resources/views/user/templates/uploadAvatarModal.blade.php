@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="user-uploadAvatar" tabindex="-1" role="dialog"
    aria-labelledby="adminisModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center" style="position:relative;">
                <h4 style="font-size:20px; font-weight:bold; text-align:center;">Thay đổi ảnh đại diện</h4>
                <span id="user-uploadAvatar-close" style=" position:absolute; right:10px; top:5px;"
                    class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align"></i></span>

            </div>


            <div class="modal-body">
                <main class="page">
                    <!-- input file -->
                    <div class="imgContainer">
                        <input type="file" id="file-input" onchange="cropImgFunc(event)">
                        <div class="result" id="inputImg" style="width : 200px;"></div>
                        <img class="imgPreview" id="imgPreview" style="width : 200px;">
                    </div>
                    <div id="slider" class="ep-slider-bar"></div>
                </main>

                <button onclick="changeAvatarSubmit()">Confirm</button>
            </div>
        </div>
    </div>
    <style>
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

    });

    let cropper = '';
    var newAvatar = '';
    function cropImgFunc(event) {
        let result = document.querySelector('#inputImg'),
            imgPreview = document.querySelector('#imgPreview');

        if (event.target.files.length) {
            // start file reader
            const reader = new FileReader();
            reader.onload = function(event) {
                if (event.target.result) {
                    // create new image
                    let img = document.createElement('img');
                    img.id = 'image';
                    img.src = event.target.result;
                    img.width = 544;
                    img.height = 370;
                    // clean result before
                    result.innerHTML = '';
                    // append new image
                    result.appendChild(img);
                    // init cropper
                    cropper = new Cropper(img, {
                        viewMode: 1,
                        dragMode: 'move',
                        aspectRatio: 1,
                        autoCropArea: 0.68,
                        minContainerWidth: 544,
                        minContainerHeight: 370,
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
            step: 0.1,
            slide: function(event, ui) {
                let slideVal = ui.value;
                let zoomRatio = Math.round((slideVal - slideValGlobal) * 10) / 10;
                slideValGlobal = slideVal;
                cropper.zoom(zoomRatio);
            }
        });
    };

    function changeAvatarSubmit(){
        let formData = new FormData();
        formData.append('changeAvatar', newAvatar);
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
                    console.log('respose success');
                    $('#accept-avatar-modal').modal('hide');
                    $('#profile-avatar').attr('src', response.new_avt);
                    $('#settingInfoAvatar').attr('src', response.new_avt);
                    $('#uploading').hide();
                },
                error: function(response) {
                    $('#accept-avatar-modal').modal('hide');
                    $('#avatar-upload-warning').text("Bị lỗi rùi, thử lại nha");
                    $('#uploading').hide();
                }
            });
    }
</script>
