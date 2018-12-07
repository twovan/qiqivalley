@extends('backend.layout.app')
@section('css_code')
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="{{asset('backend/plugins/fancybox/jquery.fancybox.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title no-borders" style="display: none;">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>订单号</label>
                            <input type="text" name="order_no" value="{{$request_params->order_no}}" class="form-control">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">查询</button>
                    </form>
                </div>

                <div class="ibox-title clearfix">
                    <h5>{{$list_title_name}}
                        <small>列表</small>
                    </h5>
                    <a href="{{route('index.logout')}}" style="height: 80px;width: 140px;float: right;background-color: #ccc;text-align: center;font-size: 30px;line-height: 80px;border-radius: 10px;display: none;"><i class="fa fa-sign-out"></i> 登出</a>
                </div>
                <div class="ibox-content">

                    <table class="footable table table-stripped toggle-arrow-tiny" data-sort="false">
                        <thead>
                            <tr>
                                <th data-toggle="true">订单号</th>
                                <th>排队号</th>
                                <th>門店</th>
                                <th>服务</th>
                                <th>支付方式</th>
                                <th>支付金额</th>
                                <th>服务时间</th>
                                <th>状态</th>
                                <th>发型记录</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($lists as $list)
                            <tr>
                                <td>{{$list->order_no}}</td>
                                <td>{{$list->queue_no}}</td>
                                <td>{{$list->store->name}}</td>
                                <td>{{$list->service->name}}</td>
                                <td>{{config('params')['pay_type'][$list->pay_type]}}</td>
                                <td>{{$list->pay_fee}}</td>
                                <td>{{$list->finished_at}}</td>
                                <td>{{config('params')['order_status'][$list->status]}}</td>
                                <td>
                                    @if($list->img_url)
                                        @if(gettype(unserialize($list->img_url)) == 'array')
                                            @foreach(unserialize($list->img_url) as $img_list)
                                                <a  class="fancybox" data-fancybox-group="g{{$list->order_no}}"+ href="{{asset('storage/'.$img_list)}}">
                                                    <img width="100" src="{{asset('storage/'.$img_list)}}">
                                                </a>
                                            @endforeach
                                        @else
                                            <a class="fancybox" href="{{asset('storage/'.unserialize($list->img_url))}}">
                                                <img width="100" src="{{asset('storage/'.unserialize($list->img_url))}}">
                                            </a>
                                        @endif
                                    @else
                                        无
                                    @endif
                                </td>
                                <td>
                                    @if($list->status > 1)
                                        <a href="{{route('index.order.image', ['id' => $list->id])}}" class="btn btn-dark-blue btn-lg">拍照</a>
                                    @else
                                        <a href="javascript:;" class="btn btn-dark-blue btn-lg disabled">拍照</a>
                                    @endif
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

@endsection
@section('js_code')
    <script src="{{asset('backend/plugins/fancybox/jquery.fancybox.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".fancybox").fancybox({
                openEffect	: 'none',
                closeEffect	: 'none'
            });
        });
    </script>
    @endsection
