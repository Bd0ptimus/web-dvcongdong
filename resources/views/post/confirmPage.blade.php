<!doctype html>
<html lang="vi">

@include('layouts.masterLayout')
@include('layouts.header')
<link href="{{ asset('css/post/chooseTopic.css?v=') . time() }}" rel="stylesheet">

<style>
.confirmPage-text{
    font-size: 18px;
    font-weight: 600;
}
</style>

<body>
    <div class="project-content-section ">
        <div class="row chooseTopic-main d-flex justify-content-center">
            <div class="row chooseTopic-header-sec" style="width: 100%; padding:20px 0px;">
                <h3 class="chooseTopic-header chooseTopic-text">
                    Thông báo
                </h3>
            </div>

            @if($error == 1)
                <div class="row d-flex justify-content-center" style="width: 100%; padding:15px 0px;">
                    <div class="row d-flex justify-content-center">
                        <span class="confirmPage-text" style="width:auto;"><i class="fa-solid fa-circle-xmark fa-2xl" style="color:red;"></i> <span> Đã có lỗi xảy ra, vui lòng thử lại </span></span>
                        <div class="row d-flex justify-content-center"  style="margin: 20px auto;">
                            <a class="link-btn" href="{{route('post.index')}}">Quay lại trang đăng tin</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row d-block justify-content-center" style="width: 100%; padding:15px 0px;">
                    <div class="row d-flex justify-content-center">
                        <span class="confirmPage-text" style="width:auto;"><i class="fa-solid fa-thumbs-up fa-2xl" style="color:green;"></i> <span> Đăng tin thành công</span></span>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="row d-block justify-content-start" style="width:auto; margin: 20px auto;">
                            <?=$confirmText?>

                        </div>
                    </div>
                    <div class="row d-flex justify-content-center" style="margin: 20px auto;">
                        <a class="link-btn" href="{{route('home')}}">Quay lại trang chủ</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('templates.main.mainCheckingService')

</body>

<script>
</script>

</html>
