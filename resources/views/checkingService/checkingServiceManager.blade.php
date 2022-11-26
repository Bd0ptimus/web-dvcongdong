<!doctype html>
<html lang="vi">

@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
    $user_actived = USER_ACTIVATED;
    $user_suspended = USER_SUSPENDED;
    $role_admin = ROLE_ADMIN;
    $role_user = ROLE_USER;
@endphp
<link href="{{ asset('css/admin/accountManager.css?v=') . time() }}" rel="stylesheet">

<body style="position:relative;">
    <div class="project-content-section">
        <div class="row d-block justify-content-center" style="width:100%; margin:auto;">
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <h3 class="d-flex justify-content-center">
                    Dịch vụ kiểm tra
                </h3>
                <button onclick="checkModal()">TEST</button>

            </div>
            <div class="row d-flex justify-content-center" style="margin : 30px auto;" id="checkCarTables">
                <div class="row" style="width:100%; margin: 30px auto;">
                    <h4>Kiểm tra lỗi phạt xe</h4>
                    <br>
                    <h6 style="color:red;">Yêu cầu chưa kiểm tra</h6>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="checkingTable table table-bordered table-striped text-nowrap"
                            style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên người yêu cầu</th>
                                    <th scope="col">ID yêu cầu</th>
                                    <th scope="col">Biển số xe</th>
                                    <th scope="col">Chứng nhận sở hữu xe</th>
                                    <th scope="col">Thời gian gửi yêu cầu</th>
                                    <th scope="col">Trạng thái</th>
                                    @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                        <th scope="col">Thao tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carTickets['created'] as $key => $carTicketCreated)
                                    <tr>
                                        <th scope="col">{{ $key+1 }}</th>
                                        <th scope="col">{{ $carTicketCreated->user->name }}</th>
                                        <th scope="col">{{ $carTicketCreated->id }}</th>
                                        <th scope="col">{{ $carTicketCreated->car_license }}</th>
                                        <th scope="col">{{ $carTicketCreated->car_ownership_certificate }}</th>
                                        <th scope="col">{{ date('d-m-Y H:m:s', strtotime($carTicketCreated->updated_at)) }}</th>
                                        @if ($carTicketCreated->status == CHECK_REQUEST_CREATED)
                                            <th scope="col" style="color:red;">Chưa kiểm tra</th>

                                        @else
                                            <th scope="col" style="color:green;">Đã hoàn thành</th>

                                        @endif

                                        @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                            <th scope="col">
                                                <a class="action-account-btn" style="color:blue;"
                                                onclick="updateCarResult(['{{$carTicketCreated->user->id}}',
                                                '{{ $carTicketCreated->user->name}}',
                                                '{{$carTicketCreated->car_license }}',
                                                '{{$carTicketCreated->car_ownership_certificate}}',
                                                '{{date('d-m-Y H:m:s', strtotime($carTicketCreated->updated_at))}}',
                                                '{{$carTicketCreated->status == CHECK_REQUEST_CREATED?'Chưa kiểm tra':'Đã hoàn thành'}}',
                                                '{{$carTicketCreated->response_require==RESPONSE_VIA_EMAIL?$carTicketCreated->user->email:$carTicketCreated->user->phone_number}}',
                                                '{{$carTicketCreated->id}}',
                                                '{{$carTicketCreated->result_comment}}',
                                                '{{$carTicketCreated->response_require}}'])">Nhập kết quả</a>
                                            </th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <br>
                    <h6 style="color:green;">Yêu cầu đã kiểm tra</h6>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="checkingTable table table-bordered table-striped text-nowrap"
                            style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên người yêu cầu</th>
                                    <th scope="col">ID yêu cầu</th>
                                    <th scope="col">Biển số xe</th>
                                    <th scope="col">Chứng nhận sở hữu xe</th>
                                    <th scope="col">Thời gian cập nhật</th>
                                    <th scope="col">Trạng thái</th>
                                    @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                        <th scope="col">Thao tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carTickets['completed'] as $key => $carTicketCompleted)
                                    <tr>
                                        <th scope="col">{{ $key+1 }}</th>
                                        <th scope="col">{{ $carTicketCompleted->user->name }}</th>
                                        <th scope="col">{{ $carTicketCompleted->id }}</th>
                                        <th scope="col">{{ $carTicketCompleted->car_license }}</th>
                                        <th scope="col">{{ $carTicketCompleted->car_ownership_certificate }}</th>
                                        <th scope="col"> {{ date('d-m-Y H:m:s', strtotime($carTicketCompleted->updated_at)) }}</th>
                                        @if ($carTicketCompleted->status == CHECK_REQUEST_CREATED)
                                            <th scope="col" style="color:red;">Chưa kiểm tra</th>
                                        @else
                                            <th scope="col" style="color:green;">Đã hoàn thành</th>
                                        @endif

                                        @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                            <th scope="col">
                                                <a class="action-account-btn" style="color:green;"
                                                onclick='updateCarResult(["{{$carTicketCompleted->user->id}}",
                                                "{{ $carTicketCompleted->user->name}}",
                                                "{{$carTicketCompleted->car_license }}",
                                                "{{$carTicketCompleted->car_ownership_certificate}}",
                                                "{{date("d-m-Y H:m:s", strtotime($carTicketCompleted->updated_at))}}",
                                                "{{$carTicketCompleted->status == CHECK_REQUEST_CREATED?"Chưa kiểm tra":"Đã hoàn thành"}}",
                                                "{{$carTicketCompleted->response_require==RESPONSE_VIA_EMAIL?$carTicketCompleted->user->email:$carTicketCompleted->user->phone_number}}",
                                                "{{$carTicketCompleted->id}}",
                                                `{{$carTicketCompleted->result_comment}}`,
                                                `{{$carTicketCompleted->response_require}}`])'
                                                >Xem hoặc sửa kết quả</a><br>
                                                <a class="action-account-btn" style="color:blue;">Xóa kết quả</a><br>
                                                <a class="action-account-btn" style="color:red;">Xóa yêu cầu</a>

                                            </th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center" style="margin : 30px auto;" id="entryBanTables">
                <div class="row" style="width:100%; margin: 30px auto;">
                    <h4>Kiểm tra cấm nhập cảnh</h4>
                    <br>
                    <h6 style="color:red;">Yêu cầu chưa kiểm tra</h6>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="checkingTable table table-bordered table-striped text-nowrap"
                            style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên người yêu cầu</th>
                                    <th scope="col">ID yêu cầu</th>
                                    <th scope="col">Tên kiểm tra (Tiếng Nga)</th>
                                    <th scope="col">Tên kiểm tra (Tiếng Anh)</th>
                                    <th scope="col">Ngày sinh</th>
                                    <th scope="col">Mã số hộ chiếu</th>
                                    <th scope="col">Ngày hết hạn hộ chiếu</th>
                                    <th scope="col">Thời gian gửi yêu cầu</th>

                                    <th scope="col">Trạng thái</th>
                                    @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                        <th scope="col">Thao tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entryBans['created'] as $key => $entryBanCreated)
                                    <tr>
                                        <th scope="col">{{ $key +1 }}</th>
                                        <th scope="col">{{ $entryBanCreated->user->name }}</th>
                                        <th scope="col">{{ $entryBanCreated->id }}</th>
                                        <th scope="col">{{ $entryBanCreated->name_russian }}</th>
                                        <th scope="col">{{ $entryBanCreated->name_latin }}</th>
                                        <th scope="col">{{ date('d-m-Y', strtotime($entryBanCreated->dob)) }}</th>
                                        <th scope="col">{{ $entryBanCreated->passport_series }}</th>
                                        <th scope="col">
                                            {{ date('d-m-Y', strtotime($entryBanCreated->passport_expired)) }}</th>
                                        <th scope="col">
                                            {{ date('d-m-Y H:m:s', strtotime($entryBanCreated->updated_at)) }}</th>
                                        @if ($entryBanCreated->status == CHECK_REQUEST_CREATED)
                                            <th scope="col" style="color:red;">Chưa kiểm tra</th>
                                        @else
                                            <th scope="col" style="color:green;">Đã hoàn thành</th>
                                        @endif

                                        @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                            <th scope="col">
                                                <a class="action-account-btn" style="color:blue;">Nhập kết quả</a>
                                            </th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <br>
                    <h6 style="color:green;">Yêu cầu đã kiểm tra</h6>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table class="checkingTable table table-bordered table-striped text-nowrap"
                            style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên người yêu cầu</th>
                                    <th scope="col">ID yêu cầu</th>
                                    <th scope="col">Tên kiểm tra (Tiếng Nga)</th>
                                    <th scope="col">Tên kiểm tra (Tiếng Anh)</th>
                                    <th scope="col">Ngày sinh</th>
                                    <th scope="col">Mã số hộ chiếu</th>
                                    <th scope="col">Ngày hết hạn hộ chiếu</th>
                                    <th scope="col">Thời gian cập nhật</th>

                                    <th scope="col">Trạng thái</th>
                                    @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                        <th scope="col">Thao tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entryBans['completed'] as $key => $entryBanCreated)
                                    <tr>
                                        <th scope="col">{{ $key +1 }}</th>
                                        <th scope="col">{{ $entryBanCreated->user->name }}</th>
                                        <th scope="col">{{ $entryBanCreated->id }}</th>
                                        <th scope="col">{{ $entryBanCreated->name_russian }}</th>
                                        <th scope="col">{{ $entryBanCreated->name_latin }}</th>
                                        <th scope="col">{{ date('d-m-Y', strtotime($entryBanCreated->dob)) }}</th>
                                        <th scope="col">{{ $entryBanCreated->passport_series }}</th>
                                        <th scope="col">
                                            {{ date('d-m-Y', strtotime($entryBanCreated->passport_expired)) }}</th>
                                        <th scope="col">
                                            {{ date('d-m-Y H:m:s', strtotime($entryBanCreated->updated_at)) }}</th>
                                        @if ($entryBanCreated->status == CHECK_REQUEST_CREATED)
                                            <th scope="col" style="color:red;">Chưa kiểm tra</th>
                                        @else
                                            <th scope="col" style="color:green;">Đã hoàn thành</th>
                                        @endif

                                        @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                            <th scope="col">
                                                <a class="action-account-btn" style="color:green;">Xem hoặc sửa kết
                                                    quả</a><br>
                                                <a class="action-account-btn" style="color:blue;">Xóa kết quả</a><br>
                                                <a class="action-account-btn" style="color:red;">Xóa yêu cầu</a>

                                            </th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('templates.admin.checkingCarTicketResult')

</body>

<script>
    $(document).ready(function() {
        $('.checkingTable').DataTable();
        // $('#adminTable_filter').find('label').text(`Tìm kiếm :`);
        // $('#adminTable_filter').find('label').append(`<input type="search" class="" placeholder="" aria-controls="adminTable">`);

        $('#add-checking-request-result-close').on('click', function(){
            $('#add-checking-request-result').modal('hide');
        });
    });

    function resetCarTicketModal(){
        $('#carTicketModal-idRequester').text('');
        $('#carTicketModal-nameRequester').text('');
        $('#carTicketModal-carLicense').text('');
        $('#carTicketModal-certOwnerShip').text('');
        $('#carTicketModal-timeUpdated').text('');
        $('#carTicketModal-status').text('');
        $('#carTicketModal-responseVia').text('');
        $('#carTicketModal-result').text('');

        $('#carTicketBtn').val('');
    }

    function updateCarResult(data){
        console.log('data : ', data);
        resetCarTicketModal();
        $('#carTicketModal-idRequester').text(data[0]);
        $('#carTicketModal-nameRequester').text(data[1]);
        $('#carTicketModal-carLicense').text(data[2]);
        $('#carTicketModal-certOwnerShip').text(data[3]);
        $('#carTicketModal-timeUpdated').text(data[4]);
        $('#carTicketModal-status').text(data[5]);
        $('#carTicketModal-responseVia').text(data[6]);
        $('#carTicketBtn').val(data[7]);
        $('#carTicketModal-result').val(data[8]);
        $('#carTicketModalResponseOption').val(data[9]);
        $('#carTicketModalResponseAddress').val(data[6]);
        $('#carTicketModalNameRequester').val(data[1]);

        $('#add-checking-request-result').modal('show');

    }


    function checkModal() {
        console.log('modal click');
        $('#add-checking-request-result').modal('show');
    }
</script>

</html>
