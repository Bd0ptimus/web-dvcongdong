
<div class="modal fade clearfix px-5" id="service-checking-modal-container" tabindex="-1" role="dialog"
    aria-labelledby="serviceCheckingModalContainer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width: 1000px;">
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
                    <select class="mbTabletModalTitle" id="mbModalTitle">
                        <option class="mbModal" id="mbModalCheckCarTicket" value="1">Kiểm tra phạt xe</option>
                        <option class="mbModal" id="mbModalAdministrative" value="2">Kiểm tra lỗi hành chính</option>
                        <option class="mbModal" id="mbModalTaxdebt" value="3">Kiểm tra nợ thuế</option>
                        <option class="mbModal" id="mbModalEntryBan" value="4">Kiểm tra cấm nhập cảnh</option>
                    </select>
                </div>
                <div class="tablet-only">
                    <select class="mbTabletModalTitle" id="tabletModalTitle">
                        <option class="mbModal" id="tabletModalCheckCarTicket" value="1">Kiểm tra phạt xe</option>
                        <option class="mbModal" id="tabletModalAdministrative" value="2">Kiểm tra lỗi hành chính</option>
                        <option class="mbModal" id="tabletModalTaxdebt" value="3">Kiểm tra nợ thuế</option>
                        <option class="mbModal" id="tabletModalEntryBan" value="4">Kiểm tra cấm nhập cảnh</option>
                    </select>
                </div>
                <span id="main-checking-service-modal-close" class="fs-4" ><i class="fa-regular fa-circle-xmark" style="float:right; width: 20px; height:20px; margin-right:5px;"></i></span>

            </div>


            <div class="modal-body">
                <form id="modalBodyCarTicket" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <h1>car</h1>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                </form>

                <form id="modalBodyAdministrative" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <h1>adminis</h1>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                </form>

                <form id="modalBodyTaxdebt" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <h1>tax</h1>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                </form>

                <form id="modalBodyEntryBan" class="serviceCheckingModalBody" method="POST" action=""> @csrf
                    <h1>entry</h1>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0" style="display:block; justify-content: center;">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="25" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-xs-4 h-100 m-0">
                            <h5 class="mt-3">Thông tin</h5>
                        </div>
                        <div class="col-xs-7 h-100 m-0">
                            <input maxlength="55" name='userName' type="text" class="form-control h-100"
                                value="" />
                        </div>
                    </div>
                </form>

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
                padding:  10px 0px 10px 5px;
            }
        }
    </style>
</div>
<script type="text/javascript">
    function controlServiceCheckingModal(index) {
        $('.serviceCheckingModalBody').hide();
        $('.modalTitle').removeClass('modal-active');
        $('.mbModal').removeAttr("selected");
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

    $('#mbModalTitle').on('change', function(){
        controlServiceCheckingModal(parseInt($('#mbModalTitle').val()));
    })

    $('#tabletModalTitle').on('change', function(){
        controlServiceCheckingModal(parseInt($('#tabletModalTitle').val()));
    })

    function test(){
        console.log('checkign service model');
    }

    $(document).ready(function() {
        $('.mbTabletModalTitle').select2({
            width: "100%",
            placeholder: 'Phân loại',
            selectionCssClass: 'header-function-sec',
        });
        $('#sidebarServiceChecking').on('click', function(){
            console.log(' sidebarServiceChecking click');
            modalShow(1);
        })

        function modalShow(index){
            //index : 1-checkCarTicket
            //index : 2-checkAdminist
            //index : 3-checkTaxdebt
            //index : 4-checkEntryBan
            controlServiceCheckingModal(index);
            $('#service-checking-modal-container').modal('show');
        }

        $('#main-checking-service-modal-close').on('click', function(){
            $('#service-checking-modal-container').modal('hide');
        })

    });
</script>
