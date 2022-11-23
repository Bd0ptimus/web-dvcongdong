<!doctype html>
<html>
@include('layouts.masterLayout')
@include('layouts.header')
<link href="{{ asset('css/post/chooseTopic.css?v=') . time() }}" rel="stylesheet">

<body>
    <div class="project-content-section ">
        <div class="row chooseTopic-main d-flex justify-content-center">
            <div class="row chooseTopic-header-sec" style="width: 100%; padding:20px 0px;">
                <h3 class="chooseTopic-header chooseTopic-text">
                    {{$header}}
                </h3>
            </div>

            <div class="row d-flex justify-content-center" style="width: 100%; padding:15px 0px;">
                <div class="row">
                    <h3 class="chooseTopic-title chooseTopic-text">
                        Chọn chuyên mục đăng tin
                    </h3>
                </div>

                <div class="row" style="margin : 30px 0px;">
                    <form class="login100-form validate-form" name="login" action="" method="post"
                        enctype="multipart/form-data"> @csrf
                        <div class="row d-flex justify-content-center" style="width:100%; margin:auto;">
                            <div class="row d-flex justify-content-center">
                                <div class="filter-section">
                                    <h5 class="row">
                                        <span class="form-text">Bạn muốn đăng tin về lĩnh vực ? <span
                                                class="text-danger">(*)</span></span>
                                    </h5>
                                    <select class="main-filter-classify classify-select" name="mainFilterClassify">
                                        <option value="0">-Chọn một lĩnh vực-</option>
                                        @foreach ($classifies as $classify)
                                            <option value="{{ $classify->id }}">{{ $classify->classify_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-section classify-type" style="display:none">
                                    <h5 class="row">
                                        <span class="form-text">Chọn chuyên mục ? <span
                                                class="text-danger">(*)</span></span>
                                    </h5>
                                    <select class="main-filter-classify classify-type-select"
                                        name="mainFilterClassifyType">
                                        <option value="0">Tất cả</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center" style="margin:auto;">
                            <button class="web-button button-disabled" id="choose-topic-btn" type="submit"
                                value="choosetopic" name="choosetopic-btn" disabled>
                                <i class="fa-solid fa-arrow-right"></i> Tiếp tục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('templates.main.mainCheckingService')

</body>

<script>
    function formatTextClassify(icon) {
        return $('<span><i class="fa-solid fa-bars"></i>     ' + icon.text + '</span>');
    };
    $('.main-filter-classify').select2({
        width: "100%",
        placeholder: 'Phân loại',
        templateSelection: formatTextClassify,
        selectionCssClass: 'header-function-sec',
    });
    $(document).ready(function() {
        $('.classify-select').on('change', function() {
            let classifyId = $('.classify-select').find(':selected').val();

            $.ajax({
                method: 'post',
                url: '{{ route('post.chooseTopic') }}',
                data: {
                    classifyId: classifyId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    if (data.data.haveChildType) {
                        $('.classify-type-select option').each(function() {
                            $(this).remove();
                        });
                        $('.classify-type-select').append(
                            `<option value="0">-chọn chuyên mục-</option>`);
                        data.data.classifyTypes.classify_types.forEach(function(e) {
                            $('.classify-type-select').append(
                                `<option value="${e.id}">${e.type_name}</option>`
                            );
                        });
                        $('.classify-type').show();
                        if ($('.classify-select').find(':selected').val() != 0 && $('.classify-type').find(':selected').val() != 0) {
                            setButtonActiveDisabled(0, 'choose-topic-btn');
                        }else{
                            setButtonActiveDisabled(1, 'choose-topic-btn');
                        }
                    } else {
                        $('.classify-type-select option').each(function() {
                            $(this).remove();
                        });
                        $('.classify-type').hide();
                        if ($('.classify-select').find(':selected').val() != 0) {
                            setButtonActiveDisabled(0, 'choose-topic-btn');
                        }else{
                            setButtonActiveDisabled(1, 'choose-topic-btn');
                        }
                    }

                },
                error: function(response) {
                    console.log('error: ', JSON.stringify(response));
                    setButtonActiveDisabled(1, 'choose-topic-btn');
                }

            });
        })

        $('.classify-type').on('change', function() {
            if ($('.classify-select').find(':selected').val() != 0 && $('.classify-type').find(
                    ':selected').val() != 0) {
                setButtonActiveDisabled(0, 'choose-topic-btn');
            } else {
                setButtonActiveDisabled(1, 'choose-topic-btn');
            }
        })
    });
</script>

</html>
