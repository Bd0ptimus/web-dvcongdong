@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="imgShow-modal" tabindex="-1" role="dialog"
    aria-labelledby="imgShowModalContainer" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <span id="imgShow-modal-close" style="background-color:black;" class="fs-4"><i class="fa-regular fa-circle-xmark"
                style="float:right; width: 20px; height:20px;  margin:5px; color:white;"></i></span>

            <div class="modal-body">
                <div class="imgShowSec">
                    <img id="imgShow-modal-img" class="imgShow-image"  alt="logo upload">

                </div>
            </div>
        </div>
    </div>
    <style>

        .modal{
            padding:0px !important;
        }
        .imgShowSec{
            background-color:black;
            width  :100%;
            height : 100%;
        }

        .modal-dialog{
            margin: 1% auto;
            height: auto;
            width : 100%;
            display: flex;
            max-width: 1000px;
            max-height : 95vh;
            overflow: hidden;
        }

        .imgShow-image{
            width : 100%;
            height: auto;
            max-height : 1000px;
            object-fit: cover;
        }

        .modal-body{
            padding:0px;
        }

        .modal-body::-webkit-scrollbar{
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
