@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd weui-media-box_text">
                <h4 class="weui-media-box__title fontc-black">排号信息</h4>
                <p class="weui-media-box__desc">感谢您对合理屋的支持，请记住您的排队号码</p>
            </div>
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_appmsg evaluate-web">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" src="{{$list->customer->wx_avatar}}" alt="">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">{{$list->service->name}}</h4>
                        <p class="weui-media-box__desc">订单时间：{{$list->created_at}}</p>
                        <p class="weui-media-box__desc">预约门店：{{$list->store->name}}</p>
                        <p class="weui-media-box__desc">门店地址：{{$list->store->address}}</p>
                    </div>
                </div>
            </div>

            <div class="weui-cells">
                <div class="weui-cell weui-cell_access">
                    <div class="weui-cell__bd">排号信息</div>
                    <span class="user_span-ft">{{$list->queue_no}}</span>
                </div>
                <div class="weui-cell weui-cell_access">
                    <div class="weui-cell__bd">合计</div>
                    <span class="user_span-ft">￥{{$list->pay_fee}}</span>
                </div>
                <div class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__bd weui-media-box_text">
                        <div class="weui-flex">
                            <div class="weui-flex__item order-btn-list">
                                @if($list->status == 1)
                                    <a id="save_btn" href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary">确认服务</a>
                                @elseif($list->status == 2)
                                    <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary weui-btn_disabled">待评价</a>
                                @elseif($list->status == 3)
                                    <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary weui-btn_disabled">已完成</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="weui-panel weui-panel_access">
            <div class="evaluate-add weui-panel__bd">
                <div class="weui-media-box">
                    <p class="weui-media-box__desc">订单编号：{{$list->order_no}}</p>
                    <p class="weui-media-box__desc">付款时间：{{$list->pay_at}}</p>
                    <p class="weui-media-box__desc">支付方式：{{config('params.pay_type')[$list->pay_type]}}</p>
                </div>
            </div>
        </div>

        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'order'])
    </div>
@endsection

@section('js')
    <script>
        wx.config({!! $app->jssdk->buildConfig(array('scanQRCode'), env('WECHAT_DEBUG')) !!});
        $(function () {
            $('#save_btn').click(function () {
                wx.scanQRCode({
                    needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                    scanType: ["qrCode"], // 可以指定扫二维码还是一维码，默认二者都有
                    success: function (res) {
                        if(res.errMsg == 'scanQRCode:ok'){
                            var form_url = '{{url('wechat/order/serviceOk')}}';
                            var jump_url = '{{url('wechat/order')}}';
                            var id = '{{$list->id}}';
                            var data = {
                                order_no: res.resultStr,
                                store_id: '{{$list->store_id}}',
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
