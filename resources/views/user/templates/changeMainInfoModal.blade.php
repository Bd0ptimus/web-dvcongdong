@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="user-uploadUserMainInfo" tabindex="-1" role="dialog"
    aria-labelledby="adminisModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center" style="position:relative;">

                <h4 style="font-size:20px; font-weight:bold; text-align:center; padding:0px 50px;">Thay đổi thông tin</h4>
                <span id="uploadUserMainInfo-close" style=" position:absolute; right:10px; top:5px;" class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align" ></i></span>
            </div>


            <div class="modal-body">

                <form id="userInfoMainForm" method="POST" action="{{route('user.setting.changeMainInfo',['userId' => $user->id])}}"> @csrf
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Tên</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" id="userInfo-name" name='userInfoName'
                                type="text" class="form-control h-100" value="" required />
                        </div>
                    </div>

                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Số điện thoại</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input type="phone" id="userInfo-phone"
                                    class="data-field form-control" name="userInfoPhone"
                                    value="" required autocomplete="phone">
                        </div>
                    </div>

                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Email</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25"
                                type="text" class="form-control h-100" name="userInfoEmail" value="{{$user->email}}" @if(Admin::user()!==null && Admin::user()->email!=null) disabled @endif />
                        </div>
                    </div>

                </form>

            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button id="userInfoSubmitChangeBtn" type="button" class="btn modal-btn">Xác nhận</button>
            </div>
        </div>
    </div>
    <style>
        #userInfoSubmitChangeBtn {
            background-color: #1d8daf;
            color: white;
            border: solid 1px #1d8daf;
        }

        #userInfoSubmitChangeBtn:hover {
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
const phoneInputField = document.querySelector("#userInfo-phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        preferredCountries: ["us", "ru", "vn"],
        initialCountry: "ru",
        // geoIpLookup: getIp,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    function userInfoChangeFormStyleReset(){
        var setupBorderColor = "rgba(0, 0, 0, 0.175)";
        $('#userInfo-name').css('border-color', setupBorderColor);
        $('#userInfo-phone').css('border-color', setupBorderColor);
    }

    $(document).ready(function() {
        $('#uploadUserMainInfo-close').on('click', function() {
            $('#user-uploadUserMainInfo').modal('hide');
        })

        $('#userInfoSubmitChangeBtn').on('click', function(){
            userInfoChangeFormStyleReset();
            var haveError = false;
            var data = {};
            if ($('#userInfo-name').val() == "") {
                $('#userInfo-name').css('border-color', 'red');
                haveError = true;
            }
            if ($('#userInfo-phone').val() == "") {
                // $('#userInfo-phone').css('border-color', 'red');
                // haveError = true;
            }else{
                if(phoneInput.getNumber().indexOf("+") == -1){
                    $('#userInfo-phone').css('border-color', 'red');
                    haveError = true;
                }
            }

            if (!haveError) {
                $('#userInfo-phone').val(phoneInput.getNumber());
                $('#userInfoMainForm').submit();
            }

        });

    });
</script>
