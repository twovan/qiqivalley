@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title no-borders">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>店铺名称：</label>
                            <input type="text" name="name" value="{{$request_params->name}}" class="form-control">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">查询</button>

                    </form>
                </div>

                <div class="ibox-title clearfix">
                    <h5>{{$list_title_name}}
                        <small>列表</small>
                    </h5>
                    <div class="pull-right">
                        <button class="btn btn-info btn-xs" data-form="add-model" data-toggle="modal" data-target="#formModal">添加</button>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table table-stripped toggle-arrow-tiny" data-sort="false">
                        <thead>
                            <tr>
                                <th>名称</th>
                                {{--<th>展示链接</th>--}}
                                <th>地址</th>
                                <th>图片</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($lists as $list)
                            <tr>
                                <td>{{$list->name}}</td>
                                {{--<td><a target="_blank" href="{{url('index/showstore',['id' => $list->id])}}">{{url('index/showstore',['id' => $list->id])}}</a></td>--}}
                                <td>{{$list->address}}</td>
                                <td>
                                    @if($list->upload_url)
                                        <img width="100" src="{{asset('storage/'.$list->upload_url)}}">
                                    @endif
                                </td>
                                <td>{{config('params')['status'][$list->status]}}</td>
                                <td><button class="btn btn-white btn-xs" data-form="edit-model" data-toggle="modal" data-target="#formModal"
                                        data-id="{{$list->id}}"
                                        data-name="{{$list->name}}"
                                        data-address="{{$list->address}}"
                                        data-upload_id="{{$list->upload_id}}"
                                        data-upload_url="{{$list->upload_url}}"
                                        data-status="{{$list->status}}"
                                    >修改</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$lists->appends($request_params->all())->render()}}

                </div>

            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="formModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">{{$list_title_name}}编辑</h4>
                </div>
                <form method="post" id="form-validate-submit" class="form-horizontal m-t">
                    <div class="modal-body">
                        @include('backend.store.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary btn-sm">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!--    js    -->
@section('js_code')
<script>

    $(function () {
        var form_url = '{{route('backend.store.save')}}';
        var index_url = window.location.href;
        var rules = [];
        subActionAjaxValidateForMime('#form-validate-submit', rules, form_url, index_url);


        /**
         * 点击添加按钮触发的操作
         */
        $('[data-form="add-model"]').click(function () {
            var n = '';
            $('#form-id').val(n);
            $('#form-name').val(n);
            $('#form-address').val(n);
            $('[data-toggle="upload-idInput-one"]').val(n);
            $('[data-toggle="upload-progressInput-one"]').val(n);
            $('#form-status').val(1).trigger('chosen:updated');
        });
        /**
         * 点击修改按钮触发的操作
         */
        $('[data-form="edit-model"]').click(function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var address = $(this).attr('data-address');
            var upload_id = $(this).attr('data-upload_id');
            var upload_url = $(this).attr('data-upload_url');
            var status = $(this).attr('data-status');
            $('#form-id').val(id);
            $('#form-name').val(name);
            $('#form-address').val(address);
            $('[data-toggle="upload-idInput-one"]').val(upload_id);
            $('[data-toggle="upload-progressInput-one"]').val(upload_url);
            $('#form-status').val(status).trigger('chosen:updated');
        });
    });

</script>
@endsection