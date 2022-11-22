<!doctype html>
<html>

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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<body style="position:relative;">
    <div class="project-content-section">
        <div class="row d-block justify-content-center" style="width:100%; margin:auto;">
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <h3 class="d-flex justify-content-center">
                    Quản lý tài khoản
                </h3>

            </div>
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <div class="row" style="width:100%; margin: 30px auto;">
                    <h6>Tài khoản Admin</h6>
                    @if (Admin::user() !== null && Admin::user()->isRole(ROLE_SUPER_ADMIN))
                        <div class="row" style="width : 200px;">
                            <a class="normal-button" style="height:30px; text-decoration: none;" href="{{route('admin.account.createAccount',['accountType'=>$role_admin])}}">
                                <i class="fa-solid fa-user-plus"></i><span style="font-size: 10px;"> Thêm tài khoản admin</span>
                            </a>
                        </div>
                    @endif
                    <div class="table-responsive" style="margin-top:20px;">
                        <table id="adminTable" class="table table-bordered table-striped text-nowrap" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Trạng thái</th>
                                    @if (Admin::user() !== null && Admin::user()->isRole(ROLE_SUPER_ADMIN))
                                        <th scope="col">Thao tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $key => $admin)
                                    <tr>
                                        <th scope="col">{{ $key }}</th>
                                        <th scope="col">{{ $admin->name }}</th>
                                        <th scope="col">{{ $admin->id }}</th>
                                        <th scope="col">{{ $admin->username }}</th>
                                        <th scope="col">{{ $admin->email }}</th>
                                        @if ($admin->active)
                                            <th scope="col" style="color:green;">Đã kích hoạt </th>
                                            @if (Admin::user() !== null && Admin::user()->isRole(ROLE_SUPER_ADMIN))
                                                <td>
                                                    <a class="action-account-btn" style="color:red;" onclick="changeAccountAction({{$admin->id}}, {{$user_suspended}})">Đình chỉ tài
                                                        khoản</a>
                                                </td>
                                            @endif
                                        @else
                                            <th scope="col" style="color:red;">Đã đình chỉ</th>
                                            @if (Admin::user() !== null && Admin::user()->isRole(ROLE_SUPER_ADMIN))
                                                <td>
                                                    <a class="action-account-btn" style="color:green;" onclick="changeAccountAction({{$admin->id}}, {{$user_actived}})">Kích hoạt tài
                                                        khoản</a>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>
                <div  class="row" style="width:100%; margin: 30px auto;">
                    <h6>Tài khoản người dùng</h6>
                    @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                        <div class="row" style="width : 200px;">
                            <a class="normal-button" style="height:30px; text-decoration: none;" href="{{route('admin.account.createAccount',['accountType'=>$role_user])}}">
                                <i class="fa-solid fa-user-plus"></i><span style="font-size: 10px;"> Thêm tài khoản
                                    người dùng</span>
                            </a>
                        </div>
                    @endif
                    <div class="table-responsive" style="overflow:scroll; margin-top:20px;">
                        <table id="userTable" class="table table-bordered table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Trạng thái</th>
                                    @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                        <th scope="col">Thao tác</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <th scope="col">{{ $key }}</th>
                                        <th scope="col">{{ $user->name }}</th>
                                        <th scope="col">{{ $user->id }}</th>
                                        <th scope="col">{{ $user->username }}</th>
                                        <th scope="col">{{ $user->email }}</th>
                                        @if ($user->active)
                                            <th scope="col" style="color:green;">Đã kích hoạt </th>
                                            @if (Admin::user() !== null && Admin::user()->inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                                <td>
                                                    <a class="action-account-btn" style="color:red;" onclick="changeAccountAction({{$user->id}}, {{$user_suspended}})">Đình chỉ tài
                                                        khoản</a>
                                                </td>
                                            @endif
                                        @else
                                            <th scope="col" style="color:red;">Đã đình chỉ</th>
                                            @if (Admin::user() !== null && Admin::user() -> inRoles([ROLE_SUPER_ADMIN, ROLE_ADMIN]))
                                                <td>
                                                    <a class="action-account-btn" style="color:green;" onclick="changeAccountAction({{$user->id}}, {{$user_actived}})">Kích hoạt tài
                                                        khoản</a>
                                                </td>
                                            @endif
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
</body>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#adminTable').DataTable();
        $('#userTable').DataTable();
        // $('#adminTable_filter').find('label').text(`Tìm kiếm :`);
        // $('#adminTable_filter').find('label').append(`<input type="search" class="" placeholder="" aria-controls="adminTable">`);

    });
    function changeAccountAction(userId, actionStatus) {
        var url = "{{ route('admin.account.changeAction') }}";
        $.ajax({
            method: 'post',
            url: url,
            data: {
                userId: userId,
                actionStatus : actionStatus,
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log('data response : ', JSON.stringify(data));
                if(data.error == 0){
                    window.location.reload();
                }
            }

        });

    }

</script>


</html>
