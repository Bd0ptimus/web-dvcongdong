<!doctype html>
<html lang="vi">
@include('layouts.masterLayout')
@include('layouts.header')
<body style="position:relative;">
    <div class="row justify-content-center project-content-section ">
        <div class="row vertical-container" style="height:90vh;">
            <div class="row d-flex justify-content-center vertical-element-middle-align" style="width:100%;">
                <span style="width:auto;"><i class="fa-solid fa-circle-xmark fa-2xl" style="color:red;"></i>  <span style="font-size:18px; font-weight: 600;"> Tài khoản của bạn đã bị đình chỉ, vui lòng sử dụng tài khoản khác!</span></span>
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
