@extends('weChat.layout.app')
@section('title', 'test')
@section('body')
    <div class="weui-toptips weui-toptips_warn js_tooltips">错误提示</div>
    <div class="container">
        <div class="page__bd">
            <div class="weui-btn-area">
                <a class="weui-btn  weui-btn_primary" href="javascript:" id="btn_save">确定</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
//            wx.config({
//                debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//                appId: '', // 必填，公众号的唯一标识
//                timestamp: '', // 必填，生成签名的时间戳
//                nonceStr: '', // 必填，生成签名的随机串
//                signature: '',// 必填，签名，见附录1
//                jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
//            });
//            wx.checkJsApi({
//                jsApiList: ['chooseImage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
//                success: function(res) {
//                    // 以键值对的形式返回，可用的api值true，不可用为false
//                    // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
//                }
//            });
        });
    </script>
@endsection