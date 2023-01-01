@php
    use App\Admin;
@endphp
<div class="modal fade clearfix px-5" id="user-uploadDescription" tabindex="-1" role="dialog"
    aria-labelledby="userDescriptionModalContainer" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog modal-dialog-centered " role="document"
        style="max-width: 1000px; width: 100%; margin : auto;">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center" style="position:relative;">
                <h4 style="font-size:20px; font-weight:bold; text-align:center; padding:0px 50px;">Chỉnh sửa giới thiệu</h4>
                <span id="user-uploadDescription-close" style=" position:absolute; right:10px; top:5px;"
                    class="modal-close-btn d-flex justify-content-center">
                    <i class="fa-solid fa-xmark fa-xl icon-align"></i></span>

            </div>


            <div class="modal-body">
                <main class="page">
                    <!-- input file -->
                    <form  method="POST" action="{{route('user.setting.changeDescription',['userId'=>$user->id])}}"> @csrf
                        <textarea type="text" name="description"  class="form-control data-field" id="userDescriptionTextField"
                            style="min-height : 50px; height: 70px; resize: none; overflow:auto;">
                            {{$user->user_description}}
                        </textarea>
                        <div class="d-flex justify-content-center">
                            <button class="normal-button" type="submit">Xác nhận</button>
                        </div>
                    </form>
                </main>

            </div>
        </div>
    </div>
    <style>

        #user-uploadDescription{
            z-index:2001;
        }
        .modal-active {
            /* border-bottom: solid 3px #1d8daf; */
            color: white;
            background-color: #1d8daf;
            border-top-right-radius: 8px 8px;
            border-top-left-radius: 8px 8px;
        }

        .modalTitle {
            float: left;
            margin: 0px;
            padding: 10px 10px 0px;
        }

        .modalTitle:hover {
            transition: 0.4s;
            cursor: pointer;
            color: white;
            /* border-bottom: solid 3px #1d8daf; */
            background-color: #1d8daf;
            border-top-right-radius: 8px 8px;
            border-top-left-radius: 8px 8px;

        }


        @media screen and (min-width : 1020px) and (max-width: 5000px) {
            .modal-header {
                padding: 10px 20px 0px;
            }
        }


        @media screen and (min-width : 820px) and (max-width: 1020px) {
            .modal-header {
                padding: 10px 20px 0px;
            }
        }


        @media screen and (min-width : 450px) and (max-width: 820px) {
            .modal-header {
                padding: 10px 0px 10px 5px;
            }
        }


        @media screen and (max-width: 450px) {
            .modal-header {
                padding: 10px 0px 10px 5px;
            }
        }
    </style>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#user-uploadDescription-close').on('click', function() {
            $('#user-uploadDescription').modal('hide');
        })

    });

</script>
