@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd weui-media-box_text">
                <h4 class="weui-media-box__title fontc-black">核对订单</h4>
                <p class="weui-media-box__desc">请认真核对订单后下单</p>
            </div>
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_appmsg evaluate-web">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" src="{{asset('storage/'.$list->upload_url)}}" alt="">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">{{$list->name}}</h4>
                        <p class="weui-media-box__desc">预约门店：{{$list->store->name}}</p>
                        <p class="weui-media-box__desc">门店地址：{{$list->store->address}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="weui-panel weui-panel_access">

            <div class="weui-cells__title">
                <h4 class="weui-media-box__title fontc-black">支付方式</h4>
            </div>
            <div class="weui-cells weui-cells_radio">
                <label class="weui-cell weui-check__label" for="x11">
                    <div class="weui-cell__bd weui-media-box_appmsg">
                        <img style="width: 24px;margin-right: 12px;" src="{{asset('weui/images/wepay_logo_green_200x200.png')}}">
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title fz13">微信支付</h4>
                            <p class="weui-media-box__desc fz10">感谢您的支持</p>
                        </div>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
            </div>
        </div>

        <div class="footer-weui-tab">
            <div class="weui-tab">
                <div class="weui-tabbar">
                    <div class="weui-form-preview w100p">
                        <div class="weui-form-preview__ft">
                            <div class="weui-form-preview__btn weui-form-preview__btn_default fz15">
                                合计 ￥{{$list->price}}
                            </div>
                            <a id="btn_save" class="weui-form-preview__btn weui-form-preview__btn_primary fz15" href="javascript:">立即支付</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        wx.config({!! $app->jssdk->buildConfig(array('chooseWXPay'), env('WECHAT_DEBUG')) !!});
        $(function () {
            $('#btn_save').click(function () {
                if('{{$is_exist}}' == 'ok'){
                    weui.alert('您已预约过该服务');
                    return false;
                }
                wx.chooseWXPay({
                    timestamp: '{{$sdk['timestamp']}}',
                    nonceStr: '{{$sdk['nonceStr']}}',
                    package: '{{$sdk['package']}}',
                    signType: '{{$sdk['signType']}}',
                    paySign: '{{$sdk['paySign']}}', // 支付签名
                    success: function (res) {
                        if(res.errMsg == 'chooseWXPay:ok'){
                            var form_url = '{{url('wechat/order/add')}}';
                            var jump_url = '{{url('wechat/order')}}';
                            var data = {
                                store_id: '{{$list->store_id}}',
                                service_id: '{{$list->id}}',
                                trade_no: '{{$trade_no}}',
                                pay_fee: '{{$list->price}}',
                                pay_type: 'wxPay'
                            };
                            subActionAjaxForMime(form_url, data, jump_url);
                        }
                    }
                });
            });
        });
    </script>
    @endsection
