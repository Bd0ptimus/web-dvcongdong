@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="adminis-modal" tabindex="-1" role="dialog"
    aria-labelledby="adminisModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center" style="position:relative;">

                <h4 style="font-size:20px; font-weight:bold; text-align:center;">Kiểm tra lỗi hành chính</h4>
                <span id="adminis-modal-close" style=" position:absolute; right:10px; top:5px;" class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align" ></i></span>
            </div>


            <div class="modal-body">

                <form id="adminisEntryBan" class="adminisModalBody" method="POST" action=""> @csrf
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Họ tên - Tiếng Nga</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" id="adminis-nameRussian" name='adminis-nameRussian'
                                type="text" class="form-control h-100" value="" required />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Ngày sinh</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" id="adminis-dob" name='adminis-dob'
                                type="date" class="form-control h-100" value="" required />
                        </div>
                    </div>

                    <div class="row my-1">
                        <div class="col-ms-6" style="width : 40%;">
                            <h6 class="mt-2">Số hộ chiếu</h6>
                            <input maxlength="55" id="adminis-passportSeries" name='adminis-passportSeries'
                                type="text" class="form-control" value="" required />
                        </div>
                        <div class="col-ms-6" style="width : 60%;">
                            <h6 class="mt-2">Ngày hết hạn hộ chiếu</h6>
                            <input maxlength="55" id="adminis-passportExpiredDate"
                                name='adminis-passportExpiredDate' type="date" class="form-control" required/>
                        </div>
                    </div>
                </form>
                <div class="row col-ms-6" style="margin-top: 20px;">
                    <h6>Nhận thông báo thông qua:</h6>
                    <select class="select-btn" id="checkingResponse" name="checkingResponse" style="width:auto;">
                        @if (isset(Admin::user()->email))
                            <option value="{{ RESPONSE_VIA_EMAIL }}">{{ Admin::user()->email }}</option>
                        @endif
                        @if (isset(Admin::user()->phone_number))
                            <option value="{{ RESPONSE_VIA_PHONE }}">{{ Admin::user()->phone_number }}</option>
                        @endif

                    </select>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button id="adminisCheckingServiceBtn" type="button" class="btn modal-btn">Xác nhận</button>
            </div>
        </div>
    </div>
    <style>
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
    function adminisResetFormStyle() {
        var setupBorderColor = "rgba(0, 0, 0, 0.175)";
        $('#adminis-nameRussian').css('border-color', setupBorderColor);
        $('#adminis-dob').css('border-color', setupBorderColor);
        $('#adminis-passportSeries').css('border-color', setupBorderColor);
        $('#adminis-passportExpiredDate').css('border-color', setupBorderColor);


    }

    function adminisResetForms() {
        $('#adminis-nameRussian').val("");
        $('#adminis-dob').val("");
        $('#adminis-passportSeries').val("");
        $('#adminis-passportExpiredDate').val("");
    }

    $(document).ready(function() {
        $('#adminis-modal-close').on('click', function() {
            $('#adminis-modal').modal('hide');
        })

        $('#adminisCheckingServiceBtn').on('click', function() {
            adminisResetFormStyle();
            var haveError = false;
            var data = {};
            if ($('#adminis-nameRussian').val() == "") {
                $('#adminis-nameRussian').css('border-color', 'red');
                haveError = true;
            }
            if ($('#adminis-dob').val() == "") {
                $('#adminis-dob').css('border-color', 'red');
                haveError = true;
            }
            if ($('#adminis-passportSeries').val() == "") {
                $('#adminis-passportSeries').css('border-color', 'red');
                haveError = true;
            }
            if ($('#adminis-passportExpiredDate').val() == "") {
                $('#adminis-passportExpiredDate').css('border-color', 'red');
                haveError = true;
            }

            if (!haveError) {
                data = {
                    userId: '<?= Admin::user() !== null ? Admin::user()->id : '' ?>',
                    checkingType: <?= ADMINISTRATIVE_TYPE ?>,
                    name: $('#adminis-nameRussian').val(),
                    dob: $('#adminis-dob').val(),
                    passportSeries: $('#adminis-passportSeries').val(),
                    passportExpiredDate: $('#adminis-passportExpiredDate').val(),
                    responseRequire: $('#checkingResponse').val(),

                };
            }
            if (!haveError) {
                sendRequestChecking(data);
            }
        });

    });
</script>
