<!doctype html>
<html lang="vi">
@include('layouts.masterLayout')
@include('layouts.header')
<body style="position:relative;">
    <div class="row justify-content-center project-content-section ">
        <div class="row vertical-container" style="height:90vh;">
            <div class="row d-flex justify-content-center vertical-element-middle-align" style="width:100%;">
                <span style="width:auto; text-align:center;"><i class="fa-solid fa-face-smile-wink fa-2xl" style="color:orangered;"></i>  <span style="font-size:18px; font-weight: 600; text-align:center;"> Vui lòng đăng nhập để sử dụng chức năng này!</span></span>
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
