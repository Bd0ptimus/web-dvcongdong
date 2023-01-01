@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="user-uploadUserInfo" tabindex="-1" role="dialog"
    aria-labelledby="userInfoModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center" style="position:relative;">
                <h4 style="font-size:20px; font-weight:bold; text-align:center; padding:0px 50px;">Chỉnh sửa thông tin cá nhân</h4>
                <span id="user-uploadUserInfo-close" style=" position:absolute; right:10px; top:5px;"
                    class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align"></i></span>

            </div>


            <div class="modal-body">
                <div class="d-block justify-content-center my-3">
                    <div class="d-flex justify-content-start">
                        <h4 class="info-change-title">Ảnh đại diện</h4>
                    </div>
                    <div class="d-flex justify-content-end">
                        <h6 class="info-change-btn" onclick="userInfoChange(1)">Thay đổi</h6>
                    </div>
                    <div class="d-flex justify-content-center">
                        <img id="userInfoAvatar" src="{{asset($user->user_avatar)}}" class="uploadInfo-avatar">
                    </div>
                </div>
                <hr/>
                <div class="d-block justify-content-center my-3">
                    <div class="d-flex justify-content-start">
                        <h4 class="info-change-title">Giới thiệu</h4>
                    </div>
                    <div class="d-flex justify-content-end">
                        <h6 class="info-change-btn" onclick="userInfoChange(2)">Thay đổi</h6>
                    </div>
                    <div class="d-flex justify-content-center">
                        <textarea type="text" name="description"  class="form-control data-field" id="userInfoDescription"
                            style="min-height : 50px; height: 70px; resize: none; overflow:auto;" disabled>
                        </textarea>
                    </div>
                </div>
                <hr/>

                <div class="d-block justify-content-center my-3">
                    <div class="d-block justify-content-center">
                        <div class="d-flex justify-content-start">
                            <h4 class="info-change-title">Thông tin</h4>
                        </div>
                        <div class="d-flex justify-content-end">
                            <h6 class="info-change-btn" onclick="userInfoChange(3)">Thay đổi</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="d-block justify-content-center" style="width:95%;">
                            <div class="d-flex justify-content-between">
                                <h5 style="margin-bottom:16px;">
                                    Tên
                                </h5>
                                <p>
                                    {{$user->name}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 style="margin-bottom:16px;">
                                    Số điện thoại
                                </h5>
                                <p >
                                    {{$user->phone_number}}
                                </p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <h5 style="margin-bottom:16px;">
                                    Email
                                </h5>
                                <p>
                                    {{$user->email}}
                                </p>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>
    <style>
        #user-uploadUserInfo{
            z-index:2000;
        }
        .info-change-btn{
            font-size:15px;
            text-align:center;
            text-decoration:underline;
            cursor: pointer;
        }

        .info-change-title{
            font-size:15px;
            font-weight:bold;
            text-align:center;
        }
        :root {
            --avatar-size: 200px;
        }

        .uploadInfo-avatar{
            width : var(--avatar-size);
            height : var(--avatar-size);
            border-radius: 50%;
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
        $('#user-uploadUserInfo-close').on('click', function() {
            $('#user-uploadUserInfo').modal('hide');
        })

    });

    function userInfoChange(index) {

        $('#user-uploadUserInfo').modal('hide');
        switch(index){
            case 1: // change avatar info clicked
                openAvatarModal();
                break;
            case 2: // change description info clicked
                changeDescriptionBtn();
                break;
            case 3: // change main info
                changeMainInfoBtn();
                break;
        }
    }

</script>
