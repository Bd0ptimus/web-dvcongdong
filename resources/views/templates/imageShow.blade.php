@php
    use App\Admin;
@endphp
<div class="modal modal-img fade clearfix px-5" id="imgShow-modal" tabindex="-1" role="dialog"
    aria-labelledby="imgShowModalContainer" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-img modal-dialog-centered " role="document">
        <div class="modal-content"  style="background-color:black;">
            <span id="imgShow-modal-close" style="background-color:black; border-radius: 10px;" class="fs-4"><i class="fa-regular fa-circle-xmark"
                style="float:right; width: 20px; height:20px;  margin:5px; color:white;"></i></span>

            <div class="modal-body modal-body-img">
                <div class="imgShowSec">
                    <img id="imgShow-modal-img" class="imgShow-image"  alt="logo upload">

                </div>
            </div>
        </div>
    </div>
    <style>

        .modal-img{
            padding:0px !important;
        }
        .imgShowSec{
            background-color:black;
            width  :100%;
            height : 100%;

        }

        .modal-dialog-img{
            margin: 1% auto;
            height: auto;
            width : 100%;
            display: flex;
            max-width: 1000px;
            max-height : 95vh;
            overflow: hidden;
            border-radius: 10px;
        }

        .imgShow-image{
            width : 100%;
            height: auto;
            max-height : 400px;
            object-fit: cover;
            border-radius: 10px;

        }

        .modal-body-img{
            padding:0px;
        }

        .modal-body-img::-webkit-scrollbar{
            width: 0px;
        }

    </style>
</div>
<script type="text/javascript">


    $(document).ready(function() {
        $('#imgShow-modal-close').on('click', function() {
            $('#imgShow-modal').modal('hide');
        })

    });
</script>
