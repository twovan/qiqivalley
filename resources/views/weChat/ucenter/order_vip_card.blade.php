@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd weui-media-box_text">
                <h4 class="weui-media-box__title fontc-black">365畅理卡</h4>
                <p class="weui-media-box__desc">购买365畅理卡 每天1元，一年365元，全年不限次！</p>
            </div>
            <div class="page__hd weui-panel__bd">
                <div class="weui-media-box weui-media-box_appmsg">
                    <img class="w100p br10" src="{{asset('weui/images/wx_vip_year_card.jpeg')}}">
                </div>
            </div>
        </div>
        <div class="weui-panel__bd bgc-white">
            <div class="weui-media-box weui-media-box_text">
                <h4 class="weui-media-box__title">持卡须知</h4>
                <h5>有效期： </h5>
                <p class="weui-media-box__desc"> 自购买之日起一年之内使用有效 逾期作废</p>
                <br>
                <h5>预约信息： </h5>
                <p class="weui-media-box__desc">免预约 如当前人数较多请稍加等候</p>
                <br>
                <h5>适用人群： </h5>
                <p class="weui-media-box__desc">仅限男士 </p>
                <br>
                <h5>规则提醒： </h5>
                <p class="weui-media-box__desc">·此卡仅限本人在合理屋银泰店及天地店使用</p>
                <p class="weui-media-box__desc">·仅限剪发项目使用(此项目不包含洗发)其他项目需另付费</p>
                <p class="weui-media-box__desc">·此卡不与其他优惠活动同时进行</p>
                <p class="weui-media-box__desc">·如遇特殊节假日需参照店内标准另加收服务费</p>
                <p class="weui-media-box__desc" style="-webkit-line-clamp:5;">·已购买年卡用户如对此卡有异议，在您提出申请(5个工作日)，我司会按【购卡后一个月内退卡，可退购卡金额的60%一至三个月之内退卡，可退购卡金额的30%，三个月之后退购卡金额的10%】</p>
                <p class="weui-media-box__desc">·退卡须持本人有效证件到原办卡店退款</p>
                <p class="weui-media-box__desc">·如有变更详见店内公告，在法律允许范围内本公司本公司保留对此卡条款的最终解释权</p>

     
            </div>
            <div class="weui-media-box weui-media-box_text">
                <h4 class="weui-media-box__title">推荐码</h4>
                <div class="weui-cell__bd">
                    <input id="recommend_no" class="weui-input" type="text" placeholder="请输入推荐码">
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
                        <img style="width: 24px;margin-right: 12px;" src="{{asset('weui/images/wepay_logo_green_200x200.png')}}" alt="">
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title fz13">微信支付</h4>
                            <p class="weui-media-box__desc fz10">推荐微信支付</p>
                        </div>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
            </div>
        </div>

        @include('weChat.layout.copyright')

        <div class="footer-weui-tab">
            <div class="weui-tab">
                <div class="weui-tabbar">
                    <div class="weui-form-preview w100p">
                        <div class="weui-form-preview__ft">
                            <div class="weui-form-preview__btn weui-form-preview__btn_default fz15">合计 ￥{{$total_fee}}</div>
                            @if($is_buy_vip)
                                <a id="chooseWXPay" class="weui-form-preview__btn weui-form-preview__btn_primary fz15" href="javascript:">立即支付</a>
                                @else
                                <a class="weui-form-preview__btn weui-form-preview__btn_default fz15" href="javascript:">立即支付</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script type="text/javascript" charset="utf-8">
        wx.config({!! $app->jssdk->buildConfig(array('chooseWXPay'), env('WECHAT_DEBUG')) !!});

        // 10.1 发起一个支付请求
        document.querySelector('#chooseWXPay').onclick = function () {
            @if(empty($get_user->phone))
                weui.alert('请先绑定手机号');
                setTimeout("location.href='http://qqg.twovan.cn/wechat/user/edit_phone?vip=1'", 1000);  
                return false;
            @endif
            // 注意：此 Demo 使用 2.7 版本支付接口实现，建议使用此接口时参考微信支付相关最新文档。
            wx.chooseWXPay({
                timestamp: '{{$sdk['timestamp']}}',
                nonceStr: '{{$sdk['nonceStr']}}',
                package: '{{$sdk['package']}}',
                signType: '{{$sdk['signType']}}',
                paySign: '{{$sdk['paySign']}}', // 支付签名
                success: function (res) {
                    if(res.errMsg == 'chooseWXPay:ok'){
                        var form_url = '{{url('wechat/user/postVipCard')}}';
                        var jump_url = '{{url('wechat/user')}}';
                        var data = {
                            trade_no: '{{$trade_no}}',
                            recommend_no: $('#recommend_no').val(),
                            price: '{{$total_fee}}'
                        };
                        subActionAjaxForMime(form_url, data, jump_url);
                    }
                }
            });
        };
    </script>
@endsection
