@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title no-borders">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>服务名称：</label>
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
                                <th>所属门店</th>
                                <th>服务名称</th>
                                <th>价格</th>
                                <th>门票数</th>
                                <th>简介</th>
                                <th>图片</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($lists as $list)
                            <tr>
                                <td>{{$list->name}}</td>
                                <td>{{$list->store->name}}</td>
                                <td>{{$list->price}}</td>
                                <td>{{$list->ticket_num or 0}}</td>
                                <td>{{$list->remark}}</td>
                                <td>
                                    @if($list->upload_url)
                                        <img width="100" src="{{asset('storage/'.$list->upload_url)}}">
                                    @endif
                                </td>
                                <td>{{config('params')['status'][$list->status]}}</td>
                                <td><button class="btn btn-white btn-xs" data-form="edit-model" data-toggle="modal" data-target="#formModal"
                                        data-id="{{$list->id}}"
                                        data-name="{{$list->name}}"
                                        data-store_id="{{$list->store_id}}"
                                        data-price="{{$list->price}}"
                                        data-ticket_num="{{$list->ticket_num}}"
                                        data-status="{{$list->status}}"
                                        data-remark="{{$list->remark}}"
                                        data-upload_id="{{$list->upload_id}}"
                                        data-upload_url="{{$list->upload_url}}"
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
                        @include('backend.service.form')
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
        var form_url = '{{route('backend.service.save')}}';
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
            $('#form-store_id').val(n);
            $('#form-ticket_num').val(n);
            $('#form-price').val(n);
            $('#form-remark').val(n);
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
            var store_id = $(this).attr('data-store_id');
            var price = $(this).attr('data-price');
            var ticket_num = $(this).attr('data-ticket_num');
            var status = $(this).attr('data-status');
            var remark = $(this).attr('data-remark');
            var upload_id = $(this).attr('data-upload_id');
            var upload_url = $(this).attr('data-upload_url');
            $('#form-id').val(id);
            $('#form-name').val(name);
            $('#form-store_id').val(store_id);
            $('#form-price').val(price);
            $('#form-ticket_num').val(ticket_num);
            $('#form-remark').val(remark);
            $('[data-toggle="upload-idInput-one"]').val(upload_id);
            $('[data-toggle="upload-progressInput-one"]').val(upload_url);
            $('#form-status').val(status).trigger('chosen:updated');
        });
    });

</script>
@endsection