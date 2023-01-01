@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="carTiket-modal" tabindex="-1" role="dialog"
    aria-labelledby="serviceCheckingModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            {{-- <div class="modal-header">
                Kiểm tra phạt xe
                <span id="carTiket-modal-close" class="fs-4"><i class="fa-regular fa-circle-xmark"
                        style="float:right; width: 20px; height:20px; margin-right:5px;"></i></span>

            </div> --}}

            <div class="modal-header d-flex justify-content-center" style="position:relative;">
                <h4 style="font-size:20px; font-weight:bold; text-align:center;">Kiểm tra phạt xe</h4>
                <span id="carTiket-modal-close" style=" position:absolute; right:10px; top:5px;" class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align" ></i></span>

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

                <div class="row col-ms-6" style="margin-top: 20px;">
                    <h6>Nhận thông báo thông qua:</h6>
                    @if ((!isset(Admin::user()->email)||Admin::user()->email=='') && (!isset(Admin::user()->phone_number)||Admin::user()->phone_number==''))
                        <br><h6 style="color:red;">Bạn chưa đăng ký email hoặc số điện thoại : </h6><span><a class="text-link" @if(Admin::user()!==null) href="{{route('user.index',['userId'=> Admin::user()->id])}} @endif">cập nhật</a></span>
                    @else
                    <select class="select-btn" id="checkingResponse" name="checkingResponse" style="width:auto;">
                        @if (isset(Admin::user()->email))
                            <option value="{{ RESPONSE_VIA_EMAIL }}">{{ Admin::user()->email }}</option>
                        @endif
                        @if (isset(Admin::user()->phone_number))
                            <option value="{{ RESPONSE_VIA_PHONE }}">{{ Admin::user()->phone_number }}</option>
                        @endif

                    </select>
                    @endif
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button id="carTicketCheckingServiceBtn" type="button" class="btn modal-btn">Xác nhận</button>
            </div>
        </div>
    </div>
    <style>
        #carTicketCheckingServiceBtn {
            background-color: #1d8daf;
            color: white;
            border: solid 1px #1d8daf;
        }

        #carTicketCheckingServiceBtn:hover {
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
    function carTicketResetFormStyle() {
        var setupBorderColor = "rgba(0, 0, 0, 0.175)";
        $('#checkCar-carLicense').css('border-color', setupBorderColor);
        $('#checkCar-certCarOwnerShip').css('border-color', setupBorderColor);
    }

    function carTicketResetForms() {
        $('#checkCar-carLicense').val("");
        $('#checkCar-certCarOwnerShip').val("");
    }

    $(document).ready(function() {
        $('#carTiket-modal-close').on('click', function() {
            $('#carTiket-modal').modal('hide');
        })

        $('#carTicketCheckingServiceBtn').on('click', function() {
            carTicketResetFormStyle();
            var haveError = false;
            var data = {};
            if ($('#checkCar-carLicense').val() == "") {
                $('#checkCar-carLicense').css('border-color', 'red');
                haveError = true;

            }
            if ($('#checkCar-certCarOwnerShip').val() == "") {
                $('#checkCar-certCarOwnerShip').css('border-color', 'red');
                haveError = true;

            }

            if($('#checkingResponse').length == 0){
                $('#toast-fail-text').text('Bạn chưa cập nhật Email hoặc Số điện thoại');
                $('#notification-fail').toast('show');
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

            if (!haveError) {
                sendRequestChecking(data);
            }
        });

    });
</script>
