{{--{{$inputId or 'one'}} 为了区分上传一--}}
{{--{{$modelName or 'image'}} 上传form表单的name--}}
{{--{{$modelIdName or 'image_id'}} 上传form表单的文件id--}}
{{--{{$actionCtrl}}//上传function--}}
{{--{{$uploadPath}}//上传到远程目录--}}
<link href="{{asset('backend/plugins/jquery-file-upload/webuploader.css')}}" type="text/css" rel="stylesheet">

<div class="clearfix">
    <div class="col-sm-5 webuploader-col-one">
        <input type="hidden" name="{{$modelIdName or 'upload_id'}}" data-toggle="upload-idInput-{{$inputId or 'one'}}">
        <input type="text" name="{{$modelName or 'upload_url'}}" data-toggle="upload-progressInput-{{$inputId or 'one'}}" readonly="" class="form-control input-sm webuploader-input">
    </div>
    <div class="col-sm-7 webuploader-col-two clearfix">
        <div id="fileupload-{{$inputId or 'one'}}" class="webuploader-container">
            <div class="webuploader-pick">上传</div>
            <input type="file" name="file" class="webuploader-element-invisible" multiple="multiple">
        </div>
        <div id="progress-{{$inputId or 'one'}}" class="progress webuploader-progress" style="">
            <div role="progressbar" class="progress-bar progress-bar-info">
                <span></span>
            </div>
        </div>
    </div>
    <div id="files-{{$inputId or 'one'}}"></div>
</div>

<script src="{{asset('backend/plugins/jquery-ui/jquery.ui.min.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-file-upload/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-file-upload/jquery.fileupload.js')}}"></script>
<script>
    $(function () {
        // ajax 添加csrf
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        'use strict';
        var probar{{$inputId or 'one'}} = $('#progress-{{$inputId or 'one'}} .progress-bar');
        $('#fileupload-{{$inputId or 'one'}} .webuploader-pick').click(function () {
            $('#fileupload-{{$inputId or 'one'}} input[type="file"]').click();
        });
        $('#fileupload-{{$inputId or 'one'}}').fileupload({
{{--            url: '/backend/upload/{{$actionCtrl or 'image'}}?path={{$uploadPath or 'image'}}',--}}
            url: '{{route('backend.'.$actionCtrl,['path' => $uploadPath])}}',
            dataType: 'json',
            done: function (e, data) {
                var result = data.result;
                if(200 == result.code){
                    probar{{$inputId or 'one'}}.removeClass('progress-bar-info')
                            .addClass('progress-bar-success');
                    $('[data-toggle="upload-progressInput-{{$inputId or 'one'}}"]').val(result.data.save_name);
                    $('[data-toggle="upload-idInput-{{$inputId or 'one'}}"]').val(result.data.save_id);
                }else {
                    probar{{$inputId or 'one'}}.removeClass('progress-bar-info')
                            .addClass('progress-bar-danger');
                }
                probar{{$inputId or 'one'}}.find('span').text(result.msg);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                probar{{$inputId or 'one'}}.removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info')
                        .css('width', progress + '%')
                        .find('span').text(Math.round(progress) + '%');
            },
            error:function () {
                probar{{$inputId or 'one'}}.removeClass('progress-bar-info')
                        .addClass('progress-bar-danger').find('span').text('上传失败');
            }
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
