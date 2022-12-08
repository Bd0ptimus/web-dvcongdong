<!doctype html>
<html lang="vi">
@include('layouts.masterLayout')
@include('layouts.header')
<body style="position:relative;">
    <div class="row justify-content-center project-content-section ">
        <div class="row vertical-container" style="height:90vh;">
            <div class="row d-flex justify-content-center vertical-element-middle-align" style="width:100%;">
                @if($user->third_party_type == SYSTEM)
                    <span style="width:auto;"><i class="fa-solid fa-circle-xmark fa-2xl" style="color:red;"></i>  <span style="font-size:18px; font-weight: 600;"> Email này đã được đăng ký ở tài khoản của hệ thống. Vui lòng đăng nhập bằng tên đăng nhập và mật khẩu của hệ thống.</span></span>

                @elseif($user->third_party_type == GOOGLE)
                    <span style="width:auto;"><i class="fa-solid fa-circle-xmark fa-2xl" style="color:red;"></i>  <span style="font-size:18px; font-weight: 600;"> Email này đã được đăng ký ở tài khoản Google. Vui lòng chọn đăng nhập với tài khoản Google</span></span>

                @elseif($user->third_party_type == FACEBOOK)
                    <span style="width:auto;"><i class="fa-solid fa-circle-xmark fa-2xl" style="color:red;"></i>  <span style="font-size:18px; font-weight: 600;"> Email này đã được đăng ký ở tài khoản Facebook. Vui lòng chọn đăng nhập với tài khoản Facebook</span></span>

                @elseif($user->third_party_type == VK)
                    <span style="width:auto;"><i class="fa-solid fa-circle-xmark fa-2xl" style="color:red;"></i>  <span style="font-size:18px; font-weight: 600;"> Email này đã được đăng ký ở tài khoản VK. Vui lòng chọn đăng nhập với VK</span></span>

                @endif

            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        setTimeout(function() {
           window.location.href = '{{route("auth.login")}}'
       }, 3000);
    })
</script>


</html>
