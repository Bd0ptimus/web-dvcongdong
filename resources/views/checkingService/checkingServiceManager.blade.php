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
                {{-- <button onclick="checkModal()">TEST</button> --}}

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
                                                <a class="action-account-btn" style="color:blue;" onclick="removeResult({{CAR_TICKET_TYPE}},{{$carTicketCompleted->id}})">Xóa kết quả</a><br>
                                                <a class="action-account-btn" style="color:red;"  onclick="removeRequirement({{CAR_TICKET_TYPE}},{{$carTicketCompleted->id}})">Xóa yêu cầu</a>

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
                                                <a class="action-account-btn" style="color:blue;"
                                                onclick="updateEntryBan([
                                                    '{{$entryBanCreated->user->id}}',
                                                    '{{$entryBanCreated->user->name}}',
                                                    '{{$entryBanCreated->name_russian}}',
                                                    '{{$entryBanCreated->name_latin }}',
                                                    '{{date('d-m-Y', strtotime($entryBanCreated->dob))}}',
                                                    '{{$entryBanCreated->passport_series}}',
                                                    '{{date('d-m-Y', strtotime($entryBanCreated->passport_expired))}}',
                                                    '{{$entryBanCreated->status == CHECK_REQUEST_CREATED?'Chưa kiểm tra':'Đã hoàn thành'}}',
                                                    '{{$entryBanCreated->response_require==RESPONSE_VIA_EMAIL?$entryBanCreated->user->email:$entryBanCreated->user->phone_number}}',
                                                    '{{$entryBanCreated->response_require}}',
                                                    '{{$entryBanCreated->id}}',
                                                    `{{$entryBanCreated->result_comment}}`
                                                ])">Nhập kết quả</a>
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
                                @foreach ($entryBans['completed'] as $key => $entryBanCompleted)
                                    <tr>
                                        <th scope="col">{{ $key +1 }}</th>
                                        <th scope="col">{{ $entryBanCompleted->user->name }}</th>
                                        <th scope="col">{{ $entryBanCompleted->id }}</th>
                                        <th scope="col">{{ $entryBanCompleted->name_russian }}</th>
                                        <th scope="col">{{ $entryBanCompleted->name_latin }}</th>
                                        <th scope="col">{{ date('d-m-Y', strtotime($entryBanCompleted->dob)) }}</th>
                                        <th scope="col">{{ $entryBanCompleted->passport_series }}</th>
                                        <th scope="col">
                                            {{ date('d-m-Y', strtotime($entryBanCompleted->passport_expired)) }}</th>
                                        <th scope="col">
                                            {{ date('d-m-Y H:m:s', strtotime($entryBanCompleted->updated_at)) }}</th>
                                        @if ($entryBanCompleted->status == CHECK_REQUEST_CREATED)
                                            <th scope="col" style="color:red;">Chưa kiểm tra</th>
                                        @else
                                            <th scope="col" style="color:green;">Đã hoàn thành</th>
                                        @endif

                                        @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                            <th scope="col">
                                                <a class="action-account-btn" style="color:green;"
                                                onclick="updateEntryBan([
                                                    '{{$entryBanCompleted->user->id}}',
                                                    '{{$entryBanCompleted->user->name}}',
                                                    '{{$entryBanCompleted->name_russian}}',
                                                    '{{$entryBanCompleted->name_latin }}',
                                                    '{{date('d-m-Y', strtotime($entryBanCompleted->dob))}}',
                                                    '{{$entryBanCompleted->passport_series}}',
                                                    '{{date('d-m-Y', strtotime($entryBanCompleted->passport_expired))}}',
                                                    '{{$entryBanCompleted->status == CHECK_REQUEST_CREATED?'Chưa kiểm tra':'Đã hoàn thành'}}',
                                                    '{{$entryBanCompleted->response_require==RESPONSE_VIA_EMAIL?$entryBanCompleted->user->email:$entryBanCompleted->user->phone_number}}',
                                                    '{{$entryBanCompleted->response_require}}',
                                                    '{{$entryBanCompleted->id}}',
                                                    `{{$entryBanCompleted->result_comment}}`
                                                ])">Xem hoặc sửa kết
                                                    quả</a><br>
                                                <a class="action-account-btn" style="color:blue;" onclick="removeResult({{ENTRY_BAN_TYPE}},{{$entryBanCompleted->id}})">Xóa kết quả</a><br>
                                                <a class="action-account-btn" style="color:red;" onclick="removeRequirement({{ENTRY_BAN_TYPE}},{{$entryBanCompleted->id}})">Xóa yêu cầu</a>

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
    @include('templates.admin.entryBanTicketResult')


</body>

<script>
    $(document).ready(function() {
        $('.checkingTable').DataTable();
        // $('#adminTable_filter').find('label').text(`Tìm kiếm :`);
        // $('#adminTable_filter').find('label').append(`<input type="search" class="" placeholder="" aria-controls="adminTable">`);

        $('#add-checking-carTicket-request-result-close').on('click', function(){
            $('#add-checking-carTicket-request-result').modal('hide');
        });

        $('#add-checking-entryBan-request-result-close').on('click', function(){
            $('#add-checking-entryBan-request-result').modal('hide');
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

    function resetEntryBanModal(){
        $('#entryBanModal-idRequester').text('');
        $('#entryBanModal-nameRequester').text('');
        $('#entryBanModal-nameRussian').text('');
        $('#entryBanModal-nameLatin').text('');
        $('#entryBanModal-dob').text('');
        $('#entryBanModal-passportSeries').text('');
        $('#entryBanModal-passportExpired').text('');
        $('#entryBanModal-status').text('');
        $('#entryBanModal-responseVia').text('');
        $('#entryBanModal-result').text('');
        $('#entryBanModalResponseOption').text('');
        $('#entryBanModalResponseAddress').text('');
        $('#entryBanModalNameRequester').text('');

        $('#entryBanBtn').val('');
    }

    function updateCarResult(data){
        // console.log('data : ', data);
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

        $('#add-checking-carTicket-request-result').modal('show');

    }

    function updateEntryBan(data){
        resetEntryBanModal();
        $('#entryBanModal-idRequester').text(data[0]);
        $('#entryBanModal-nameRequester').text(data[1]);
        $('#entryBanModal-nameRussian').text(data[2]);
        $('#entryBanModal-nameLatin').text(data[3]);
        $('#entryBanModal-dob').text(data[4]);
        $('#entryBanModal-passportSeries').text(data[5]);
        $('#entryBanModal-passportExpired').text(data[6]);
        $('#entryBanModal-status').text(data[7]);
        $('#entryBanModal-responseVia').text(data[8]);
        $('#entryBanModalResponseOption').val(data[9]);
        $('#entryBanModalResponseAddress').val(data[8]);
        $('#entryBanModalNameRequester').val(data[1]);
        $('#entryBanBtn').val(data[10]);
        $('#entryBanModal-result').val(data[11]);


        $('#add-checking-entryBan-request-result').modal('show');
    }

    function removeResult(checkingType, id){
        var url = "{{ route('admin.checkingInfo.removeResult') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                checkingType: checkingType,
                id: id,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    window.location.href = '{{ route('admin.checkingInfo.index') }}'
                }
            }

        });
    }


    function removeRequirement(checkingType, id){
        var url = "{{ route('admin.checkingInfo.removeRequirement') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                checkingType: checkingType,
                id: id,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    window.location.href = '{{ route('admin.checkingInfo.index') }}'
                }
            }

        });
    }


    function checkModal() {
        console.log('modal click');
        $('#add-checking-entryBan-request-result').modal('show');
    }
</script>

</html>
