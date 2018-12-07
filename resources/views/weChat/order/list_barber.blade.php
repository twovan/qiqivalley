@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-cells order_title">
            <div class="weui-flex">
                <div class="weui-flex__item">
                    <a class="weui-cell weui-cell_access @if($request_status == 0) active @endif" href="{{url('wechat/order')}}?status=0">全部</a>
                </div>
                <div class="weui-flex__item">
                    <a class="weui-cell weui-cell_access @if($request_status == 1) active @endif" href="{{url('wechat/order')}}?status=1">待服务</a>
                </div>
                <div class="weui-flex__item">
                    <a class="weui-cell weui-cell_access @if($request_status == 2) active @endif" href="{{url('wechat/order')}}?status=2">待评价</a>
                </div>
                <div class="weui-flex__item">
                    <a class="weui-cell weui-cell_access @if($request_status == 3) active @endif" href="{{url('wechat/order')}}?status=3">已完成</a>
                </div>
            </div>
        </div>
        @if($store_orders)
            @foreach($store_orders as $list)
                <div class="weui-panel weui-panel_access order_list">
                    <div class="weui-panel__hd">
                        <h4 class="weui-media-box__title store_title">{{$list->store->name}}
                            <small>{{config('params')['order_status'][$list->status]}}</small>
                        </h4>
                    </div>
                    <div class="weui-panel__hd weui-panel__bd">
                        <a href="{{url('wechat/order',['id' => $list->id])}}" class="weui-media-box weui-media-box_appmsg evaluate-web">
                            <div class="weui-media-box__hd">
                                <img class="weui-media-box__thumb" src="{{$list->customer->wx_avatar}}" alt="">
                            </div>
                            <div class="weui-media-box__bd">
                                <h4 class="weui-media-box__title">{{$list->service->name}}<small>排号信息：{{$list->queue_no}}</small></h4>
                                <p class="weui-media-box__desc">订单时间：{{$list->created_at}}</p>
                                <p class="weui-media-box__desc">门店地址：{{$list->store->address}}</p>
                            </div>
                        </a>
                    </div>
                    <div class="weui-panel__hd">
                        <h4 class="weui-media-box__title btn_title">
                            @if($list->pay_type == 'yearCard')
                                年卡支付
                            @else
                                合计 ￥{{$list->pay_fee}}
                            @endif                        
                            @if($list->status == 1)
                                <a data-id="{{$list->id}}" data-store_id="{{$list->store_id}}" href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary save_btn">确认服务</a>
                            @elseif($list->status == 2)
                                <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary weui-btn_disabled">待评价</a>
                            @elseif($list->status == 3)
                                <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary weui-btn_disabled">已完成</a>
                            @endif
                        </h4>
                    </div>
                </div>
            @endforeach
        @endif
        @foreach($lists as $list)
            <div class="weui-panel weui-panel_access order_list">
                <div class="weui-panel__hd">
                    <h4 class="weui-media-box__title store_title">{{$list->store->name}}
                        <small>{{config('params')['order_status'][$list->status]}}</small>
                    </h4>
                </div>
                <div class="weui-panel__hd weui-panel__bd">
                    <a href="{{url('wechat/order',['id' => $list->id])}}" class="weui-media-box weui-media-box_appmsg evaluate-web">
                        <div class="weui-media-box__hd">
                            <img class="weui-media-box__thumb" src="{{$list->customer->wx_avatar}}" alt="">
                        </div>
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title">{{$list->service->name}}<small>排号信息：{{$list->queue_no}}</small></h4>
                            <p class="weui-media-box__desc">订单时间：{{$list->created_at}}</p>
                            <p class="weui-media-box__desc">门店地址：{{$list->store->address}}</p>
                        </div>
                    </a>
                </div>
                <div class="weui-panel__hd">
                        <h4 class="weui-media-box__title btn_title">
                            @if($list->pay_type == 'yearCard')
                                年卡支付
                            @else
                                合计 ￥{{$list->pay_fee}}
                            @endif                    
                        @if($list->status == 1)
                            <a data-id="{{$list->id}}" data-store_id="{{$list->store_id}}" href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary save_btn">确认服务</a>
                        @elseif($list->status == 2)
                            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary weui-btn_disabled">待评价</a>
                        @elseif($list->status == 3)
                            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary weui-btn_disabled">已完成</a>
                        @endif
                    </h4>
                </div>
            </div>
        @endforeach

        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'order'])
    </div>
@endsection
@section('js')
    <script>
        wx.config({!! $app->jssdk->buildConfig(array('scanQRCode'), env('WECHAT_DEBUG')) !!});
        $(function () {
            $('.save_btn').click(function () {
                var id = $(this).attr('data-id');
                var store_id = $(this).attr('data-store_id');
                wx.scanQRCode({
                    needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                    scanType: ["qrCode"], // 可以指定扫二维码还是一维码，默认二者都有
                    success: function (res) {
                        if(res.errMsg == 'scanQRCode:ok'){
                            var form_url = '{{url('wechat/order/serviceOk')}}';
                            var jump_url = '{{url('wechat/order')}}';
                            var data = {
                                order_no: res.resultStr,
                                store_id: store_id,
                                id: id
                            };
                            subActionAjaxForMime(form_url, data, jump_url);
                        }
                    }
                });
            });
        })
    </script>
@endsection
