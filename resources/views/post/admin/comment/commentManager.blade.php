<!doctype html>
<html lang="vi">

@include('layouts.masterLayout')
@include('layouts.header')
@php
    use App\Admin;
    $commentAccept = COMMENT_ACCEPTED;
    $commentPending = COMMENT_PENDING;
    $commentReject = COMMENT_REJECTED;
@endphp
<link href="{{ asset('css/admin/accountManager.css?v=') . time() }}" rel="stylesheet">

<body style="position:relative;">
    <div class="project-content-section">
        <div class="row d-block justify-content-center" style="width:100%; margin:auto;">
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <h3 class="d-flex justify-content-center" style="font-size: 20px; font-weight: bold">
                    Quản lý đánh giá của người dùng
                </h3>

            </div>
            <div class="row d-flex justify-content-center" style="margin : 30px auto;">
                <div class="row" style="width:100%; margin: 30px auto;">
                    <h6 style="color:orange; font-size: 18px; font-weight: bold; text-align:center;">Đánh giá đang đợi duyệt</h6>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table id="cmtsPending" class="table table-bordered table-striped text-nowrap" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">ID người đánh giá</th>
                                    <th scope="col">Tên người đánh giá</th>
                                    <th scope="col">ID đánh giá</th>
                                    <th scope="col">Đánh giá</th>
                                    <th scope="col">Ảnh đánh giá</th>
                                    <th scope="col">Số sao</th>
                                    <th scope="col">ID bài viết</th>
                                    <th scope="col">Tiêu đề bài viết</th>
                                    <th scope="col">Nội dung bài viết</th>
                                    <th scope="col">Ảnh bài viết</th>
                                    <th scope="col">Người viết bài</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cmtsPending as $key => $cmtPending)
                                    <tr>
                                        <td scope="col">{{ $key+1 }}</td>
                                        <td scope="col">{{ $cmtPending->user->id }}</td>
                                        <td scope="col">{{ $cmtPending->user->name }}</td>
                                        <td scope="col">{{ $cmtPending->id }}</td>
                                        <td scope="col">{!! nl2br($cmtPending->comments) !!}</td>
                                        <td scope="col">
                                            <div style="padding:0px; width:200px;" class="d-flex justify-content-center">
                                                <div class="swiper mySwiper">
                                                    <div class="swiper-wrapper">
                                                        @foreach($cmtPending->postCommentAttachments as $cmtAttachment)
                                                            <div class="swiper-slide ">
                                                                <img class="newFeed-image2" onclick="watchImageModal('{{asset($cmtAttachment->attachment_path)}}')"
                                                                    src="{{ asset($cmtAttachment->attachment_path) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">{{ isset($cmtPending->star)?$cmtPending->star.'/5' : 'Không đánh giá'}} <span class="fa fa-star rating-star-checked"></span></td>
                                        <td scope="col">{{ $cmtPending->post->id }}</td>
                                        <td scope="col">{{ $cmtPending->post->title }}</td>
                                        <td scope="col">{!! nl2br($cmtPending->post->description) !!}</td>
                                        <td scope="col">
                                            <div style="padding:0px; width:200px;" class="d-flex justify-content-center">
                                                <div class="swiper mySwiper">
                                                    <div class="swiper-wrapper">
                                                        @foreach($cmtPending->post->post_attachments as $postAttachment)
                                                            <div class="swiper-slide ">
                                                                <img class="newFeed-image2" onclick="watchImageModal('{{asset($postAttachment->attachment_path)}}')"
                                                                    src="{{ asset($postAttachment->attachment_path) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">{{ $cmtPending->post->user->name }}</td>
                                        <th scope="col"><p style="color:orange;">Đang đợi duyệt</p></th>
                                        <th scope="col">
                                            <a style="color:green;" href="{{route('admin.commentManager.adminCommentInteract',['commentId'=>$cmtPending->id, 'status'=>$commentAccept])}}">Chấp nhận</a>
                                            <br>
                                            <a style="color:red;" href="{{route('admin.commentManager.adminCommentInteract',['commentId'=>$cmtPending->id, 'status'=>$commentReject])}}">Bỏ chấp nhận</a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>
                <div  class="row" style="width:100%; margin: 30px auto;">
                    <h6 style="color:green; font-size: 18px; font-weight: bold; text-align:center;">Đánh giá đã được chấp nhận</h6>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table id="cmtsAccepted" class="table table-bordered table-striped text-nowrap" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">ID người đánh giá</th>
                                    <th scope="col">Tên người đánh giá</th>
                                    <th scope="col">ID đánh giá</th>
                                    <th scope="col">Đánh giá</th>
                                    <th scope="col">Ảnh đánh giá</th>
                                    <th scope="col">Số sao</th>
                                    <th scope="col">ID bài viết</th>
                                    <th scope="col">Tiêu đề bài viết</th>
                                    <th scope="col">Nội dung bài viết</th>
                                    <th scope="col">Ảnh bài viết</th>
                                    <th scope="col">Người viết bài</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cmtsAccepted as $key => $cmtAccepted)
                                    <tr>
                                        <td scope="col">{{ $key+1 }}</td>
                                        <td scope="col">{{ $cmtAccepted->user->id }}</td>
                                        <td scope="col">{{ $cmtAccepted->user->name }}</td>
                                        <td scope="col">{{ $cmtAccepted->id }}</td>
                                        <td scope="col">{!! nl2br($cmtAccepted->comments) !!}</td>
                                        <td scope="col">
                                            <div style="padding:0px; width:200px;" class="d-flex justify-content-center">
                                                <div class="swiper mySwiper">
                                                    <div class="swiper-wrapper">
                                                        @foreach($cmtAccepted->postCommentAttachments as $cmtAttachment)
                                                            <div class="swiper-slide ">
                                                                <img class="newFeed-image2" onclick="watchImageModal('{{asset($cmtAttachment->attachment_path)}}')"
                                                                    src="{{ asset($cmtAttachment->attachment_path) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">{{ isset($cmtAccepted->star)?$cmtAccepted->star.'/5' : 'Không đánh giá'}} <span class="fa fa-star rating-star-checked"></span></td>
                                        <td scope="col">{{ $cmtAccepted->post->id }}</td>
                                        <td scope="col">{{ $cmtAccepted->post->title }}</td>
                                        <td scope="col">{!! nl2br($cmtAccepted->post->description) !!}</td>
                                        <td scope="col">
                                            <div style="padding:0px; width:200px;" class="d-flex justify-content-center">
                                                <div class="swiper mySwiper">
                                                    <div class="swiper-wrapper">
                                                        @foreach($cmtAccepted->post->post_attachments as $postAttachment)
                                                            <div class="swiper-slide ">
                                                                <img class="newFeed-image2" onclick="watchImageModal('{{asset($postAttachment->attachment_path)}}')"
                                                                    src="{{ asset($postAttachment->attachment_path) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">{{ $cmtAccepted->post->user->name }}</td>
                                        <td scope="col"><p style="color:green;">Đã chấp nhận</p></td>
                                        <td scope="col"><a style="color:red;" href="{{route('admin.commentManager.adminCommentInteract',['commentId'=>$cmtAccepted->id, 'status'=>$commentReject])}}">Bỏ chấp nhận</a></td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>
                <div  class="row" style="width:100%; margin: 30px auto;">
                    <h6 style="color:red; font-size: 18px; font-weight: bold; text-align:center;">Đánh giá đã bị từ chối</h6>
                    <div class="table-responsive" style="margin-top:20px;">
                        <table id="cmtRejected" class="table table-bordered table-striped text-nowrap" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">ID người đánh giá</th>
                                    <th scope="col">Tên người đánh giá</th>
                                    <th scope="col">ID đánh giá</th>
                                    <th scope="col">Đánh giá</th>
                                    <th scope="col">Ảnh đánh giá</th>
                                    <th scope="col">Số sao</th>
                                    <th scope="col">ID bài viết</th>
                                    <th scope="col">Tiêu đề bài viết</th>
                                    <th scope="col">Nội dung bài viết</th>
                                    <th scope="col">Ảnh bài viết</th>
                                    <th scope="col">Người viết bài</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cmtsRejected as $key => $cmtRejected)
                                    <tr>
                                        <td scope="col">{{ $key+1 }}</td>
                                        <td scope="col">{{ $cmtRejected->user->id }}</td>
                                        <td scope="col">{{ $cmtRejected->user->name }}</td>
                                        <td scope="col">{{ $cmtRejected->id }}</td>
                                        <td scope="col">{!! nl2br($cmtRejected->comments) !!}</td>
                                        <td scope="col">
                                            <div style="padding:0px; width:200px;" class="d-flex justify-content-center">
                                                <div class="swiper mySwiper">
                                                    <div class="swiper-wrapper">
                                                        @foreach($cmtRejected->postCommentAttachments as $cmtAttachment)
                                                            <div class="swiper-slide ">
                                                                <img class="newFeed-image2" onclick="watchImageModal('{{asset($cmtAttachment->attachment_path)}}')"
                                                                    src="{{ asset($cmtAttachment->attachment_path) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">{{ isset($cmtRejected->star)?$cmtRejected->star.'/5' : 'Không đánh giá'}} <span class="fa fa-star rating-star-checked"></span></td>
                                        <td scope="col">{{ $cmtRejected->post->id }}</td>
                                        <td scope="col">{{ $cmtRejected->post->title }}</td>
                                        <td scope="col">{!! nl2br($cmtRejected->post->description) !!}</td>
                                        <td scope="col">
                                            <div style="padding:0px; width:200px;" class="d-flex justify-content-center">
                                                <div class="swiper mySwiper">
                                                    <div class="swiper-wrapper">
                                                        @foreach($cmtRejected->post->post_attachments as $postAttachment)
                                                            <div class="swiper-slide ">
                                                                <img class="newFeed-image2" onclick="watchImageModal('{{asset($postAttachment->attachment_path)}}')"
                                                                    src="{{ asset($postAttachment->attachment_path) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">{{ $cmtRejected->post->user->name }}</td>
                                        <td scope="col"><p style="color:red;">Đã từ chối</p></td>
                                        <td scope="col"><a style="color:green;" href="{{route('admin.commentManager.adminCommentInteract',['commentId'=>$cmtRejected->id, 'status'=>$commentAccept])}}">Chấp nhận</a></td>

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
<script type="text/javascript">
var allowLoad = true;
    let swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    $(document).ready(function () {
        $('#cmtsPending').DataTable();
        $('#cmtsAccepted').DataTable();
        $('#cmtRejected').DataTable();

        // $('#adminTable_filter').find('label').text(`Tìm kiếm :`);
        // $('#adminTable_filter').find('label').append(`<input type="search" class="" placeholder="" aria-controls="adminTable">`);

    });
    // function changeAccountAction(userId, actionStatus) {
    //     var url = "{{ route('admin.account.changeAction') }}";
    //     $.ajax({
    //         method: 'post',
    //         url: url,
    //         data: {
    //             userId: userId,
    //             actionStatus : actionStatus,
    //             _token: '{{ csrf_token() }}',
    //         },
    //         success: function(data) {
    //             console.log('data response : ', JSON.stringify(data));
    //             if(data.error == 0){
    //                 window.location.reload();
    //             }
    //         }

    //     });

    // }

</script>


</html>
