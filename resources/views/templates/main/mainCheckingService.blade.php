@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="service-checking-modal-container" tabindex="-1" role="dialog"
    aria-labelledby="serviceCheckingModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            <div class="modal-header">

                <div class="pc-only">
                    <h5 class="modalTitle" onclick="controlServiceCheckingModal(1)" id="modalCheckCarTicket">
                        Kiểm tra phạt xe
                    </h5>
                    <h5 class="modalTitle" onclick="controlServiceCheckingModal(2)" id="modalAdministrative">
                        Kiểm tra lỗi hành chính
                    </h5>
                    <h5 class="modalTitle" onclick="controlServiceCheckingModal(3)" id="modalTaxdebt">
                        Kiểm tra nợ thuế
                    </h5>
                    <h5 class="modalTitle" onclick="controlServiceCheckingModal(4)" id="modalEntryBan">
                        Kiểm tra cấm nhập cảnh
                    </h5>
                </div>

                <div class="mb-only">
                    <select class="mbTabletModalTitle select-btn" id="mbModalTitle">
                        <option class="mbModal" id="mbModalCheckCarTicket" value="1">Kiểm tra phạt xe</option>
                        <option class="mbModal" id="mbModalAdministrative" value="2">Kiểm tra lỗi hành chính
                        </option>
                        <option class="mbModal" id="mbModalTaxdebt" value="3">Kiểm tra nợ thuế</option>
                        <option class="mbModal" id="mbModalEntryBan" value="4">Kiểm tra cấm nhập cảnh</option>
                    </select>
                </div>
                <div class="tablet-only">
                    <select class="mbTabletModalTitle select-btn" id="tabletModalTitle">
                        <option class="mbModal" id="tabletModalCheckCarTicket" value="1">Kiểm tra phạt xe</option>
                        <option class="mbModal" id="tabletModalAdministrative" value="2">Kiểm tra lỗi hành chính
                        </option>
                        <option class="mbModal" id="tabletModalTaxdebt" value="3">Kiểm tra nợ thuế</option>
                        <option class="mbModal" id="tabletModalEntryBan" value="4">Kiểm tra cấm nhập cảnh</option>
                    </select>
                </div>
                <span id="main-checking-service-modal-close" class="fs-4"><i class="fa-regular fa-circle-xmark"
                        style="float:right; width: 20px; height:20px; margin-right:5px;"></i></span>

            </div>


            <div class="modal-body">
                <form id="modalBodyCarTicket" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Biển số xe</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" style="border-colorsetupBorderColor" id="checkCar-carLicense"
                                name='checkCar-carLicense' type="text" class="form-control h-100" value="" />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0">
                            <h6 class="mt-2">Chứng nhận sở hữu xe</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" id="checkCar-certCarOwnerShip" name='checkCar-certCarOwnerShip'
                                type="text" class="form-control h-100" value="" />
                        </div>
                    </div>
                </form>

                <form id="modalBodyAdministrative" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <h1>adminis</h1>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Thông tin</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0">
                            <h6 class="mt-2">Thông tin</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0">
                            <h6 class="mt-2">Thông tin</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                </form>

                <form id="modalBodyTaxdebt" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <h1>tax</h1>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Thông tin</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0">
                            <h6 class="mt-2">Thông tin</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0">
                            <h6 class="mt-2">Thông tin</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                </form>

                <form id="modalBodyEntryBan" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h6 class="mt-2">Họ tên - Tiếng Nga</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" id="checkEntry-nameRussian" name='checkEntry-nameRussian'
                                type="text" class="form-control h-100" value="" required />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-xs-4 h-100 m-0">
                            <h6 class="mt-2">Họ tên - Tiếng Latin</h6>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" id="checkEntry-nameLatin" name='checkEntry-nameLatin'
                                type="text" class="form-control h-100" value="" required />
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-ms-6" style="width : 40%;">
                            <h6 class="mt-2">Giới tính</h6>
                            <select class="select-btn" name="checkEntry-gender">
                                <option value="1" selected>Nam</option>
                                <option value="2">Nữ</option>
                            </select>
                        </div>
                        <div class="col-ms-6" style="width : 60%;">
                            <h6 class="mt-2">Ngày sinh</h6>
                            <input maxlength="55" id="checkEntry-dob" name='checkEntry-dob' type="date"
                                class="form-control" value="" />
                        </div>
                    </div>

                    <div class="row my-1">
                        <div class="col-ms-6" style="width : 40%;">
                            <h6 class="mt-2">Số hộ chiếu</h6>
                            <input maxlength="55" id="checkEntry-passportSeries" name='checkEntry-passportSeries'
                                type="text" class="form-control" value="" required />
                        </div>
                        <div class="col-ms-6" style="width : 60%;">
                            <h6 class="mt-2">Ngày hết hạn hộ chiếu</h6>
                            <input maxlength="55" id="checkEntry-passportExpiredDate"
                                name='checkEntry-passportExpiredDate' type="date" class="form-control"/>
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
                <button id="checkingServiceBtn" type="button" class="btn modal-btn">Xác nhận</button>
            </div>
        </div>
    </div>
    <style>
        #checkingServiceBtn {
            background-color: #1d8daf;
            color: white;
            border: solid 1px #1d8daf;
        }

        #checkingServiceBtn:hover {
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
    //checkingType : 1-checkCarTicket
    //checkingType : 2-checkAdminist
    //checkingType : 3-checkTaxdebt
    //checkingType : 4-checkEntryBan
    var checkingType = 0;

    function controlServiceCheckingModal(index) {
        resetFormStyle();
        resetForms();
        $('.serviceCheckingModalBody').hide();
        $('.modalTitle').removeClass('modal-active');
        $('.mbModal').removeAttr("selected");
        $('#mbModalTitle').val(index);
        $('#tabletModalTitle').val(index);
        checkingType = index;

        switch (index) {
            case 1:
                $('#modalBodyCarTicket').show();
                $('#modalCheckCarTicket').addClass('modal-active');
                $('#mbModalCheckCarTicket').attr("selected", "selected");
                $('#tabletModalCheckCarTicket').attr("selected", "selected");
                break;
            case 2:
                $('#modalBodyAdministrative').show();
                $('#modalAdministrative').addClass('modal-active');
                $('#mbModalAdministrative').attr("selected", "selected");
                $('#tabletModalAdministrative').attr("selected", "selected");

                break;
            case 3:
                $('#modalBodyTaxdebt').show();
                $('#modalTaxdebt').addClass('modal-active');
                $('#mbModalTaxdebt').attr("selected", "selected");
                $('#tabletModalTaxdebt').attr("selected", "selected");

                break;
            case 4:
                $('#modalBodyEntryBan').show();
                $('#modalEntryBan').addClass('modal-active');
                $('#mbModalEntryBan').attr("selected", "selected");
                $('#tabletModalEntryBan').attr("selected", "selected");

                break;
        }
    }

    $('#mbModalTitle').on('change', function() {
        controlServiceCheckingModal(parseInt($('#mbModalTitle').val()));
    })

    $('#tabletModalTitle').on('change', function() {
        controlServiceCheckingModal(parseInt($('#tabletModalTitle').val()));
    })

    function resetFormStyle() {
        var setupBorderColor = "rgba(0, 0, 0, 0.175)";
        $('#checkCar-carLicense').css('border-color', setupBorderColor);
        $('#checkCar-certCarOwnerShip').css('border-color', setupBorderColor);
        $('#checkEntry-nameRussian').css('border-color', setupBorderColor);
        $('#checkEntry-nameLatin').css('border-color', setupBorderColor);
        $('#checkEntry-dob').css('border-color', setupBorderColor);
        $('#checkEntry-passportSeries').css('border-color', setupBorderColor);
        $('#checkEntry-passportExpiredDate').css('border-color', setupBorderColor);


    }

    function resetForms() {
        $('#checkCar-carLicense').val("");

        $('#checkCar-certCarOwnerShip').val("");

        $('#checkEntry-nameRussian').val("");

        $('#checkEntry-nameLatin').val("");

        $('#checkEntry-dob').val("");

        $('#checkEntry-passportSeries').val("");

        $('#checkEntry-passportExpiredDate').val("");

    }

    function sendRequestChecking(data) {
        console.log(data);
        var url = "{{ route('check.addNew') }}";
        $.ajax({
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            data: data,
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if (data.error == 0) {
                    $('#toast-success-text').text('Gửi yêu cầu thành công. Vui lòng đợi phản hồi');
                    $('#notification-success').toast('show');
                } else {
                    $('#toast-fail-text').text('Có lỗi xảy ra, vui lòng thử lại');
                    $('#notification-fail').toast('show');
                }
            }

        });
    }

    $(document).ready(function() {


        $('#sidebarServiceChecking').on('click', function() {
            checkUserExist();
            var isAdmin =
                '<?= Admin::user() !== null ? Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN]) : '' ?>';
            if (isAdmin == '1') {
                console.log('user is admin');
                window.location.href = '{{ route('admin.checkingInfo.index') }}'
            } else {
                modalShow(1);
            }
        })
        resetFormStyle();


        function modalShow(index) {
            //index : 1-checkCarTicket
            //index : 2-checkAdminist
            //index : 3-checkTaxdebt
            //index : 4-checkEntryBan
            controlServiceCheckingModal(index);
            $('#service-checking-modal-container').modal('show');
        }



        $('#main-checking-service-modal-close').on('click', function() {
            $('#service-checking-modal-container').modal('hide');
        })

        $('#checkingServiceBtn').on('click', function() {
            resetFormStyle();
            $('#checkingInfo-warning').empty();
            var haveError = false;
            var data = {};
            switch (checkingType) {
                case (1):
                    if ($('#checkCar-carLicense').val() == "") {
                        $('#checkCar-carLicense').css('border-color', 'red');
                        haveError = true;
                    }
                    if ($('#checkCar-certCarOwnerShip').val() == "") {
                        $('#checkCar-certCarOwnerShip').css('border-color', 'red');
                        haveError = true;
                    }

                    if (!haveError) {
                        data = {
                            userId: '<?= Admin::user() !== null ? Admin::user()->id : '' ?>',
                            checkingType: <?= CAR_TICKET_TYPE ?>,
                            carLicense: $('#checkCar-carLicense').val(),
                            certCarOwnerShip: $('#checkCar-certCarOwnerShip').val(),
                            responseRequire: $('#checkingResponse').val(),
                        };
                    }
                    break;
                case (2):
                    haveError = true;

                    break;
                case (3):
                    haveError = true;

                    break;
                case (4):
                    if ($('#checkEntry-nameRussian').val() == "") {
                        $('#checkEntry-nameRussian').css('border-color', 'red');
                        haveError = true;
                    }
                    if ($('#checkEntry-nameLatin').val() == "") {
                        $('#checkEntry-nameLatin').css('border-color', 'red');
                        haveError = true;
                    }
                    if ($('#checkEntry-dob').val() == "") {
                        $('#checkEntry-dob').css('border-color', 'red');
                        haveError = true;
                    }
                    if ($('#checkEntry-passportSeries').val() == "") {
                        $('#checkEntry-passportSeries').css('border-color', 'red');
                        haveError = true;
                    }
                    if ($('#checkEntry-passportExpiredDate').val() == "") {
                        $('#checkEntry-passportExpiredDate').css('border-color', 'red');
                        haveError = true;
                    }

                    if (!haveError) {
                        data = {
                            userId: '<?= Admin::user() !== null ? Admin::user()->id : '' ?>',
                            checkingType: <?= ENTRY_BAN_TYPE ?>,
                            nameRussian: $('#checkEntry-nameRussian').val(),
                            nameLatin: $('#checkEntry-nameLatin').val(),
                            dob: $('#checkEntry-dob').val(),
                            passportSeries: $('#checkEntry-passportSeries').val(),
                            passportExpiredDate: $('#checkEntry-passportExpiredDate').val(),
                            responseRequire: $('#checkingResponse').val(),
                        };
                    }
                    break;
            }

            if (!haveError) {
                sendRequestChecking(data);
            }
        });

    });
</script>
