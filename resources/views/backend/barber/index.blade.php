@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>员工手机：</label>
                            <input type="text" name="phone" value="{{$request_params->phone}}" class="form-control input-sm">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">查询</button>
                    </form>
                </div>

                <div class="ibox-title clearfix">
                    <h5>{{$list_title_name}}
                        <small>列表</small>
                    </h5>
                    {{--<div class="pull-right">--}}
                        {{--<button class="btn btn-info btn-xs" data-form="add-model" data-toggle="modal" data-target="#formModal">添加</button>--}}
                    {{--</div>--}}
                </div>
                <div class="ibox-content">

                    <table class="table table-stripped toggle-arrow-tiny" data-sort="false">
                        <thead>
                        <tr>
                            <th>员工手机</th>
                            <th>姓名</th>
                            <th>工号</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list->phone}}</td>
                                <td>{{$list->wx_name}}</td>
                                <td>{{$list->work_no}}</td>
                                <td>{{config('params')['status'][$list->status]}}</td>
                                <td><button class="btn btn-white btn-xs" data-form="edit-model" data-toggle="modal" data-target="#formModal"
                                            data-id="{{$list->id}}"
                                            data-phone="{{$list->phone}}"
                                            data-wx_name="{{$list->wx_name}}"
                                            data-work_no="{{$list->work_no}}"
                                            data-type="{{$list->type}}"
                                            data-status="{{$list->status}}"
                                    >修改</button></td></tr>
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
                        @include('backend.barber.form')
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
            var form_url = '{{route('backend.user.save')}}';
            var index_url = window.location.href;
            var rules = [];
            subActionAjaxValidateForMime('#form-validate-submit', rules, form_url, index_url);


            /**
             * 点击添加按钮触发的操作
             */
            $('[data-form="add-model"]').click(function () {
                var n = '';
                $('#form-id').val(n);
                $('#form-phone').val(n);
                $('#form-wx_name').val(0);
                $('#form-work_no').val(0);
                $('#form-status').val(1).trigger('chosen:updated');
            });
            /**
             * 点击修改按钮触发的操作
             */
            $('[data-form="edit-model"]').click(function () {
                var id = $(this).attr('data-id');
                var phone = $(this).attr('data-phone');
                var type = $(this).attr('data-type');
                var wx_name = $(this).attr('data-wx_name');
                var work_no = $(this).attr('data-work_no');
                var status = $(this).attr('data-status');
                $('#form-id').val(id);
                $('#form-phone').val(phone);
                $('#form-type').val(type);
                $('#form-wx_name').val(wx_name);
                $('#form-work_no').val(work_no);
                $('#form-status').val(status).trigger('chosen:updated');
            });
        });

    </script>
@endsection