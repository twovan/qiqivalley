@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title no-borders">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>订单号</label>
                            <input type="text" name="order_no" value="{{$request_params->order_no}}" class="form-control">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>店铺</label>
                            <input type="text" name="store" value="{{$request_params->store}}" class="form-control">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>发型师手机号</label>
                            <input type="text" name="barber_phone" value="{{$request_params->barber_phone}}" class="form-control">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>用户手机号</label>
                            <input type="text" name="customer_phone" value="{{$request_params->customer_phone}}" class="form-control">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>起始时间</label>
                            <input type="text" name="stime" id="search-stime" value="{{$request_params->stime}}" class="form-control">
                            <label>截止时间</label>
                            <input type="text" name="etime" id="search-etime" value="{{$request_params->etime}}" class="form-control">
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
                                <th data-toggle="true">订单号</th>
                                <th>排队号</th>
                                <th>店铺</th>
                                <th>发型师手机号</th>
                                <th>操作员姓名</th>
                                <th>用户手机号</th>
                                <th>用户身份</th>
                                <th>状态</th>
                                <th>服务时间</th>
                                <th data-hide="all">图片</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($lists as $list)
                            <tr>
                                <td>{{$list->order_no}}</td>
                                <td>{{$list->queue_no}}</td>
                                <td>{{$list->store->name}}</td>
                                <td>@if($list->barber_id){{$list->barber->phone}}@endif</td>
                                <td>@if($list->barber_id){{$list->barber->wx_name}}@endif</td>
                                <td>{{$list->customer->phone}}</td>
                                <td>{{config('params.userVip')[$list->customer->vip]}}</td>
                                <td>{{config('params.order_status')[$list->status]}}</td>
                                <td>{{$list->finished_at}}</td>
                                <td>
                                    @if($list->img_url)
                                        @if(gettype(unserialize($list->img_url)) == 'array')
                                            @foreach(unserialize($list->img_url) as $img_list)
                                                <img width="100" src="{{asset('storage/'.$img_list)}}">
                                            @endforeach
                                        @else
                                            <img width="100" src="{{asset('storage/'.unserialize($list->img_url))}}">
                                        @endif
                                    @else
                                        无
                                    @endif
                                </td>
                                <td><button class="btn btn-white btn-xs" data-form="edit-model" data-toggle="modal" data-target="#formModal"--}} data-id="{{$list->id}}"data-status="{{$list->status}}">修改</button></td>
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
                        @include('backend.order.form')
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
        var form_url = '{{route('backend.order.save')}}';
        var index_url = window.location.href;
        var rules = [];
        subActionAjaxValidateForMime('#form-validate-submit', rules, form_url, index_url);

        /**
         * 点击修改按钮触发的操作
         */
        $('[data-form="edit-model"]').click(function () {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $('#form-id').val(id);
            $('#form-status').val(status).trigger('chosen:updated');
        });


        var start = {
            elem: "#search-stime",
            format: "YYYY/MM/DD hh:mm:ss",
            min: "2010-01-01 00:00:00",
            max: "2037-12-31 23:59:59",
            istime: true,
            istoday: false,
            choose: function (datas) {
                end.min = datas;
                end.start = datas
            }
        };
        var end = {
            elem: "#search-etime",
            format: "YYYY/MM/DD hh:mm:ss",
            min: "2010-01-01 00:00:00",
            max: "2037-12-31 23:59:59",
            istime: true,
            istoday: false,
            choose: function (datas) {
                start.max = datas
            }
        };
        laydate(start);
        laydate(end);
    });

</script>
@endsection