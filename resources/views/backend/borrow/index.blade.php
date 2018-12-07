@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title no-borders">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>用户手机：</label>
                            <input type="text" name="b_name" value="{{$request_params->b_name}}" class="form-control">
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
                                <th>物品名称</th>
                                <th>借阅人</th>
                                <th>电话</th>
                                <th>借阅时间</th>
                                <th>归还时间</th>
                                <th>店铺名称</th>
                                <th>操作人</th>
                                <th>添加时间</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(collect($lists)->isEmpty())
                                <tr><td colspan="8">暂无记录</td></tr>
                            @endif
                            @foreach($lists as $list)
                                @if($list->user_id)
                                <tr>
                                    <td>{{$list->b_name}}</td>
                                    @if(collect($list->user)->isNotEmpty())
                                    <td>{{$list->user->name}}</td>
                                    <td>{{$list->user->phone}}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>{{$list->borrow_ts}}</td>
                                    <td>{{$list->back_ts}}</td>
                                    @if(collect($list->store)->isNotEmpty())
                                    <td>{{$list->store->name}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(collect($list->admin)->isNotEmpty())
                                        <td>{{$list->admin->name}}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>{{$list->created_at}}</td>
                                    <td><button class="btn btn-white btn-xs" data-form="edit-model" data-toggle="modal" data-target="#formModal"
                                            data-id="{{$list->id}}"
                                            data-b_name="{{$list->b_name}}"
                                            data-phone=" @if(collect($list->user)->isNotEmpty()) {{$list->user->phone}} @endif "
                                            data-borrow_ts="{{$list->borrow_ts}}"
                                            data-back_ts="{{$list->back_ts}}"
                                            data-store_id="@if(collect($list->store)->isNotEmpty()){{$list->store_id}} @endif "

                                        >修改</button></td>
                                </tr>
                                @endif
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
                        @include('backend.borrow.form')
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
        var form_url = '{{route('backend.borrow.save')}}';
        var index_url = window.location.href;
        var rules = [];
        subActionAjaxValidateForMime('#form-validate-submit', rules, form_url, index_url);


        /**
         * 点击添加按钮触发的操作
         */
        $('[data-form="add-model"]').click(function () {
            var n = '';
            var borrow_ts ="{{date('Y-m-d H:i:s')}}";
            $('#form-id').val(n);
            $('#form-b_name').val(n);
            $('#form-phone').val(n);
            $('#form-borrow_ts').val(borrow_ts);
            $('#form-back_ts').val(n);
            $('#form-store_id').val(n);

        });
        /**
         * 点击修改按钮触发的操作
         */
        $('[data-form="edit-model"]').click(function () {
            var id = $(this).attr('data-id');
            var b_name = $(this).attr('data-b_name');
            var phone = $(this).attr('data-phone');
            var store_id = $(this).attr('data-store_id');
            var borrow_ts = $(this).attr('data-borrow_ts');
            var back_ts = $(this).attr('data-back_ts');



            $('#form-id').val(id);
            $('#form-b_name').val(b_name);
            $('#form-phone').val(phone);
            $('#form-store_id').val(store_id);
            $('#form-borrow_ts').val(borrow_ts);
            $('#form-back_ts').val(back_ts);

        });

        var var_borrow_ts = {
            elem: "#form-borrow_ts",
            format: "YYYY/MM/DD hh:mm:ss",
            min: "2010-01-01",
            max: "2037-12-31",
            istime: true,
            istoday: false,
            choose: function (datas) {}
        };
        laydate(var_borrow_ts);

        var var_back_ts = {
            elem: "#form-back_ts",
            format: "YYYY/MM/DD hh:mm:ss",
            min: "2010-01-01",
            max: "2037-12-31",
            istime: true,
            istoday: false,
            choose: function (datas) {}
        };
        laydate(var_back_ts);
    });

</script>
@endsection