<!doctype html>
<html lang="vi">
@include('layouts.masterLayout')
@include('layouts.header')
<link href="{{ asset('css/mainScreen/index.css?v=') . time() }}" rel="stylesheet">

<body>

    <div class="project-content-section">
        <div id="img-carousel">
            @include('layouts.mainBannerSlide')
            <div id="main-search" class="d-flex justify-content-center">
                <div class="box-search-wrapper" id="main-search-section">
                    <div class="container" style="display:block; justify-content: center;">
                        <div class="row main-filter">
                            <form id="frm-search-job" action="" method="">@csrf
                                <div class="row">
                                    <div
                                        class="form-group col-sm-3 input-data vertical-container d-flex justify-content-center">
                                        <input autocomplete="off"
                                            class="form-control form-control-input-text ui-autocomplete-input vertical-element-middle-align"
                                            id="Filter_Keyword" name="Filter.Keyword" placeholder="Từ khóa"
                                            type="text" style="height: 46px; width:90%" value="">
                                    </div>
                                    <div class="form-group col-sm-3 input-data">
                                        <select class="main-filter-classify" name="main-filter-classify">
                                            <option value="0">Tất cả</option>
                                            <option value="1">Nhà đất</option>
                                            <option value="2">Dịch vụ</option>
                                            <option value="3">Việc làm</option>
                                            <option value="4">Mua bán xe cộ</option>
                                            <option value="5">May mặc</option>
                                            <option value="6">Mẹ và bé</option>
                                            <option value="7">Nhà hàng</option>
                                            <option value="8">Rao vặt, quảng cáo</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3 input-data">
                                        <select class="main-filter-position" name="main-filter-position">
                                            <option value="0">Toàn Nga</option>
                                            <option value="1">Moscow</option>
                                            <option value="2">Saint</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 search-submit vertical-container">
                                        <button
                                            class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn"
                                            type="submit" style="height: 46px; ">
                                            <i class="fa fa-search"></i><span> Tìm kiếm</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row main-filter" >
                            <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                <button id="checkCarTicket"
                                    class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                    <i class="fa-solid fa-car-on"></i><span> Kiểm tra lỗi phạt xe</span>
                                </button>
                            </div>
                            <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                <button id="checkAdministrative"
                                    class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                    <i class="fa-solid fa-book"></i><span> Kiểm tra lỗi hành chính</span>
                                </button>
                            </div>
                            <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                <button id="checkTaxdebt"
                                    class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                    <i class="fa-solid fa-coins"></i><span> Kiểm tra nợ thuế</span>
                                </button>
                            </div>
                            <div class="form-group col-sm-3 vertical-container d-flex justify-content-center">
                                <button id="checkEntryBan"
                                    class="form-control btn btn-block btn-topcv-primary btn-border btn-border-thin main-searchBtn vertical-element-middle-align main-service-checking-btn">
                                    <i class="fa-solid fa-plane-circle-xmark"></i><span> Kiểm tra cấm nhập cảnh</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('templates.main.mainCheckingService')
</body>

<script>
    $(document).ready(function() {
        function formatTextClassify(icon) {
            return $('<span><i class="fa-solid fa-bars"></i>     ' + icon.text + '</span>');
        };
        $('.main-filter-classify').select2({
            width: "100%",
            placeholder: 'Phân loại',
            templateSelection: formatTextClassify,
            selectionCssClass: 'header-function-sec',
        });


        function formatTextPosition(icon) {
            return $('<span><i class="fas fa-map-marker-alt"></i>     ' + icon.text + '</span>');
        };
        $('.main-filter-position').select2({
            width: "100%",
            placeholder: 'Vị trí',
            templateSelection: formatTextPosition,
            selectionCssClass: 'header-function-sec',
        });

        $('#checkCarTicket').on('click', function(){
            modalShow(1);
        })

        $('#checkAdministrative').on('click', function(){
            modalShow(2);
        })

        $('#checkTaxdebt').on('click', function(){
            modalShow(3);
        })

        $('#checkEntryBan').on('click', function(){
            modalShow(4);
        })

        $('#sidebarServiceChecking').on('click', function(){
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



</html>
