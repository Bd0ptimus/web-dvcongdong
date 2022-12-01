<link href="{{ asset('css/layouts/sidebar.css?v=') . time() }}" rel="stylesheet">

{{-- <div class="flex-column flex-shrink-0 p-3 bg-light open-sidebar-btn" style="width : 80px; cursor:pointer;" onclick="mbOpenFullSidebar()">
    <div class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto link text-decoration-none">
        <span class="mb-open-sidebar-icon">
            <i class="fa-solid fa-bars fa-xl fs-4" ></i>
        </span>
    </div>
</div> --}}
@php
    use App\Admin;
@endphp
<div id="full-sidebar" style="display:none; z-index:1005; overflow-y: scroll;"
    class=" flex-column flex-shrink-0 p-3 bg-light sidebar-container" onmouseleave="miniSidebar()">
    {{-- <div class="d-flex justify-content-between mb-3 mb-md-0 me-md-auto link text-decoration-none" style="width: 100%;">
        <span class="fs-4">Nguoiviettainga</span>
        <span onclick="mbCloseSidebar()" class="fs-4 mb-close-btn" style="right:0px;"><i class="fa-regular fa-circle-xmark fa-xs"></i></span>
    </div>
    <hr> --}}

    {{-- <span class="fs-4 mb-close-btn"><i class="fa-regular fa-circle-xmark fa-xl" onclick="mbCloseSidebar()"
            style="float:right; width: 20px; height:20px;"></i></span> --}}
    <ul class="nav nav-pills flex-column mb-2">
        @if (Admin::user() == !null)
            <li class="nav-item nav-item-container">
                <a href="" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-user"></i>
                    <span>
                        {{Admin::user()->name}}
                    </span>
                </a>
            </li>
        @endif
        <li class="nav-item nav-item-container">
            <a href="{{ route('search.index') }}" class="nav-link" aria-current="page">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>
                    Tìm kiếm
                </span>
            </a>
        </li>
        @if (Admin::user() == !null && Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN]))
            <li class="nav-item nav-item-container">
                <a href="{{route('admin.account.index')}}" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-users"></i>
                    <span>
                        Quản lý tài khoản
                    </span>
                </a>
            </li>
        @endif
        @if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER))
            <li class="nav-item nav-item-container">
                <a href="{{ route('post.postInteract.postLiked',['userId'=>Admin::user()->id]) }}" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-heart"></i>
                    <span>
                        Bài viết đã thích
                    </span>
                </a>
            </li>
            <li class="nav-item nav-item-container">
                <a href="{{route('post.myPost.index',['userId'=>Admin::user()->id])}}" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>
                        Bài viết của tôi
                    </span>
                </a>
            </li>
            <li class="nav-item nav-item-container">
                <a href="{{ route('post.index') }}" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>
                        Đăng tin miễn phí
                    </span>
                </a>
            </li>
        @endif
        <li class="nav-item nav-item-container">
            <a href="#" class="nav-link" aria-current="page" id="sidebarServiceChecking">
                <i class="fa-solid fa-file-circle-exclamation"></i>
                <span>
                    Dịch vụ kiểm tra
                </span>
            </a>
        </li>

        @if (Admin::user() == null)
            <li class="nav-item nav-item-container">
                <a href="{{ route('login') }}" class="nav-link" aria-current="page">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>
                        Đăng nhập
                    </span>
                </a>
            </li>
            <li class="nav-item nav-item-container">
                <a href="{{ route('register') }}" class="nav-link" aria-current="page">
                    <i class="fa-regular fa-registered"></i>
                    <span>
                        Đăng ký
                    </span>
                </a>
            </li>
        @endif



        @if (Admin::user() !== null)
            <li class="nav-item nav-item-container">
                <a href="{{ route('logout') }}" class="nav-link" aria-current="page"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>
                        Đăng xuất
                    </span>

                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf

                </form>
            </li>
        @endif

    </ul>
    <hr>
    <ul class="nav nav-pills flex-column mb-2">
        <li class="nav-item nav-item-container">
            <a href="{{ route('home') }}" class="nav-link" aria-current="page">
                <i class="fa-solid fa-house-chimney sidebar-icon"></i>
                <span>
                    TRANG CHỦ
                </span>
            </a>
        </li>
        <li class="nav-item nav-item-container">
            <a href="{{ route('post.postCategory.realEstate.index') }}"  class="nav-link ">
                <i class="fa-solid fa-building sidebar-icon"></i>
                <span>
                    NHÀ ĐẤT
                </span>
            </a>
        </li>
        <li class="nav-item nav-item-container">
            <a href="#" class="nav-link submenu" onclick="submenuActive('service-submenu')">
                <i class="fa-solid fa-hand-holding-dollar sidebar-icon"></i>
                <span>
                    DỊCH VỤ
                </span>
                <i class="fa-solid fa-caret-right" style="float : right;"></i>
            </a>
        </li>
        <div id="service-submenu" class="submenu-nav-item" style="display:none;">
            <a href="#" class="submenu-nav-link ">
                Giấy tờ
            </a>
            <br>
            <a href="#" class="submenu-nav-link">
                Y tế
            </a>
            <br>
            <a href="#" class="submenu-nav-link">
                Giáo dục
            </a>
            <br>
            <a href="#" class="submenu-nav-link">
                Du lịch
            </a>
            <br>
            <a href="#" class="submenu-nav-link">
                Điện tử
            </a>
        </div>
        <li class="nav-item nav-item-container">
            <a  href="{{ route('post.postCategory.job.index') }}" class="nav-link">
                <i class="fa-solid fa-briefcase sidebar-icon"></i>
                <span>
                    VIỆC LÀM
                </span>
            </a>
        </li>
        <li class="nav-item nav-item-container">
            <a href="{{ route('post.postCategory.carTrade.index') }}" class="nav-link ">
                <i class="fa-solid fa-car sidebar-icon"></i>
                <span>
                    MUA BÁN XE CỘ
                </span>
            </a>
        </li>
        {{-- <li class="nav-item nav-item-container">
            <a href="#" class="nav-link ">
                <i class="fa-solid fa-shirt sidebar-icon"></i>
                <span>
                    MAY MẶC
                </span>
            </a>
        </li>
        <li class="nav-item nav-item-container">
            <a href="#" class="nav-link ">
                <i class="fa-solid fa-person-breastfeeding sidebar-icon"></i>
                <span>
                    MẸ VÀ BÉ
                </span>
            </a>
        </li> --}}
        <li class="nav-item nav-item-container">
            <a href="{{ route('post.postCategory.restaurant.index') }}" class="nav-link ">
                <i class="fa-solid fa-utensils sidebar-icon"></i>
                <span>
                    NHÀ HÀNG
                </span>
            </a>
        </li>
        <li class="nav-item nav-item-container">
            <a href="{{ route('post.postCategory.ad.index') }}"  class="nav-link ">
                <i class="fa-solid fa-rectangle-ad sidebar-icon"></i>
                <span>
                    RAO VẶT
                </span>
            </a>
        </li>
        <li class="nav-item nav-item-container">
            <a href="#" class="nav-link ">
                <i class="fa-solid fa-circle-question sidebar-icon"></i>
                <span>
                    HỎI ĐÁP
                </span>
            </a>
        </li>

    </ul>
    <hr>
    <div class = "row d-flex justify-content-center" style="width:100%; margin-bottom:30px;">
        <h5 class="contact-text" style="width:auto;">Liên hệ : </h5>
        <h5 class="contact-text" style="width:auto;">+7 (929) 669-76-70 </h5>
    </div>
    <div class = "row d-flex justify-content-center" style="width:100%; margin-bottom:100px;">
        <div style="width : auto;">
            <a class = "contact-link d-flex justify-content-center" > <i class="fa-brands fa-facebook fa-xl"></i></a>

        </div>
        <div style="width : auto;">
            <a class = " contact-link d-flex justify-content-center"> <i class="fa-brands fa-instagram fa-xl"></i></a>

        </div>
        <div style="width : auto;">
            <a class = "contact-link d-flex justify-content-center" target="_blank" href=" https://wa.me/79296697670"> <i class="fa-brands fa-whatsapp fa-xl"></i></a>

        </div>
        <div style="width : auto;">
            <a class = " contact-link d-flex justify-content-center" target="_blank" href ="https://t.me/dichvucongdong"> <i class="fa-brands fa-telegram fa-xl"></i></a>

        </div>
    </div>
</div>
<div id="mini-sidebar" class="flex-column flex-shrink-0 p-3 bg-light sidebar-container"
    style="width : 5%; cursor:pointer; z-index:1000; overflow-y: hidden;" onmouseenter="fullSidebar()">
    {{-- <a href="/" class="d-flex justify-content-center align-items-center mb-md-0 me-md-auto link text-decoration-none">
        <span class="fs-4 sidebar-logo" >Logo</span>
    </a>
    <hr> --}}
    <ul class="nav nav-pills flex-column mb-2">
        @if (Admin::user() !== null)
            <li class="nav-item d-flex justify-content-center">
                <a href="#" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-solid fa-user"></i>
                </a>
            </li>
        @endif
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item" aria-current="page">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
        </li>
        @if (Admin::user() == !null && Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN]))
            <li class="nav-item d-flex justify-content-center">
                <a href="{{route('admin.account.index')}}" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-solid fa-users"></i>
                </a>
            </li>
        @endif
        @if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER))
            <li class="nav-item d-flex justify-content-center">
                <a href="{{ route('post.postInteract.postLiked',['userId'=>Admin::user()->id]) }}" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-solid fa-heart"></i>
                </a>
            </li>

            <li class="nav-item d-flex justify-content-center">
                <a href="{{route('post.myPost.index',['userId'=>Admin::user()->id])}}" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-solid fa-floppy-disk"></i>
                </a>
            </li>

            <li class="nav-item d-flex justify-content-center">
                <a href="{{ route('post.index') }}" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-solid fa-paper-plane"></i>
                </a>
            </li>
        @endif
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item" aria-current="page">
                <i class="fa-solid fa-file-circle-exclamation"></i>
            </a>
        </li>


        @if (Admin::user() == null)
            <li class="nav-item d-flex justify-content-center">
                <a href="{{ route('login') }}" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-solid fa-right-to-bracket"></i>
                </a>
            </li>
            <li class="nav-item d-flex justify-content-center">
                <a href="{{ route('register') }}" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-regular fa-registered"></i>
                </a>
            </li>
        @endif

        @if (Admin::user() !== null)
            <li class="nav-item d-flex justify-content-center">
                <a href="{{ route('logout') }}" class="nav-link nav-icon-item" aria-current="page">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </li>
        @endif

    </ul>
    <hr>
    <ul class="nav nav-pills flex-column mb-2">
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item" aria-current="page">
                <i class="fa-solid fa-house-chimney"></i>
            </a>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-building"></i>
            </a>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-hand-holding-dollar "></i>
            </a>
        </li>

        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-briefcase "></i>
            </a>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-car "></i>
            </a>
        </li>
        {{-- <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-shirt "></i>
            </a>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-person-breastfeeding "></i>
            </a>
        </li> --}}
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-utensils"></i>
            </a>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-rectangle-ad"></i>
            </a>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a href="#" class="nav-link nav-icon-item">
                <i class="fa-solid fa-circle-question "></i>
            </a>
        </li>

    </ul>
    <hr>
</div>



<script type="text/javascript">
    function submenuActive(submenuId) {
        // console.log('submenu active');
        if (document.getElementById(submenuId).style.display == "block") {
            document.getElementById(submenuId).style.display = "none";

        } else {
            document.getElementById(submenuId).style.display = "block";

        }
    }


    var mini = true;
    // var slideIsOpen = true;

    function miniSidebar() {
        // console.log("mini active");
        document.getElementById('full-sidebar').style.display = "none";
        document.getElementById('full-sidebar').classList.remove('slide-out');
        document.getElementById('full-sidebar').classList.add('slide-in');
        this.mini = true;
    }

    function fullSidebar() {
        // console.log('full side bar');
        document.getElementById('full-sidebar').style.display = "flex";
        document.getElementById('full-sidebar').classList.remove('slide-in');
        document.getElementById('full-sidebar').classList.add('slide-out');


        this.mini = false;
    }

    function mbOpenFullSidebar() {
        fullSidebar();
    }

    function mbCloseSidebar() {
        miniSidebar();
    }
</script>
