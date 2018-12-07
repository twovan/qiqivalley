@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>孩子姓名：</label>
                            <input type="text" name="name" value="{{$request_params->name}}" class="form-control input-sm">
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
                                <th>姓名</th>
                                <th>性别</th>
                                <th>出生日期</th>
                                <th>家长昵称</th>
                                <th>家长姓名</th>
                                <th>家长手机号</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($lists as $list)
                            <tr>
                                <td>{{$list->name}}</td>
                                <td> @if($list->sex == 0) 男 @else 女 @endif &nbsp;</td>
                                <td>{{$list->DOB}}</td>
                                <td>{{$list->user->wx_name}}</td>
                                <td>{{$list->user->name}}</td>
                                <td>{{$list->user->phone}}</td>
                                <td><button class="btn btn-white btn-xs" data-form="edit-model" data-toggle="modal" data-target="#formModal"
                                            data-id="{{$list->id}}"
                                            data-name="{{$list->name}}"
                                            data-sex="{{$list->sex}}"
                                            data-DOB="{{$list->DOB}}"
                                    >修改</button>
                                </td>
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
                        @include('backend.kid.form')
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
            var form_url = '{{route('backend.kid.save')}}';
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
                $('#form-sex').val(0);
                $('#form-DOB').val(n);
            });
            /**
             * 点击修改按钮触发的操作
             */
            $('[data-form="edit-model"]').click(function () {
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var sex = $(this).attr('data-sex');
                var DOB = $(this).attr('data-DOB');
                $('#form-id').val(id);
                $('#form-name').val(name);
                $('#form-sex').val(sex);
                $('#form-DOB').val(DOB);

            });

            var var_dob = {
                elem: "#form-DOB",
                format: "YYYY/MM/DD",
                min: "2010-01-01",
                max: "2037-12-31",
                istime: true,
                istoday: false,
                choose: function (datas) {}
            };
            laydate(var_dob);
        });

    </script>
@endsection