@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
<style type="text/css">
body{
    background-color: #231917;
}
h4{
    color: #fff;
}
</style>
    <div class="page__bd">
        <div class="weui-panel__bd">
            <a href="javascript:;" class="weui-media-box weui-media-box_appmsg evaluate-web" style="margin: 32px 0 0 32px">
                <div class="weui-media-box__hd"  style="width: 420px;height: auto; margin-right: 26px">
                    <img class="full-img" src="{{asset('weui/images/qrcode_for_gh_d4fe6fd8503e_1280.jpg')}}">
                    <p style="font-size: 60px;font-weight: bolder;line-height: 70px;color: #fff;">微信扫码体验<br>¥50 / 位</p>
                </div>
                <div class="weui-media-box__bd evaluate-add" style="width: auto;height: auto;">
                    <p class="weui-media-box__desc" style="font-size: 50px;color: #fff;">{{$list->name}}</p>
                    <p class="weui-media-box__desc" style="font-size: 20px;color: #fff;">发型师：</p>
                    <ul class="weui-media-box__info web-user-list">
                        @foreach($get_work_lists as $get_work_list)
                            <li><img src="{{$get_work_list->barber->wx_avatar}}"><span>{{$get_work_list->barber->wx_name}}</span></li>
                        @endforeach
                    </ul>
                    @if($order_count == 0)
                        <p class="weui-media-box__desc" style="font-size: 20px;color: #fff;">当前可直接服务哦</p>
                    @else
                        <p class="weui-media-box__desc" style="font-size: 20px;color: #fff;">当前排队人数 {{$order_count}} 人
                               {{-- ，预计等候时间 {{($order_count - 1) * 20}} ~ {{$order_count * 20}} 分钟--}}
                            ，预计等候时间 10-20 分钟
                        </p>
                        <ul class="weui-media-box__info web-user-list">
                            @foreach($order_lists as $order_list)
                                <li><img src="{{$order_list->customer->wx_avatar}}"><span>{{$order_list->queue_no}}</span></li>
                            @endforeach 
                        </ul>
                    @endif
                </div>
            </a>
        </div>
    </div>
    @include('weChat.layout.copyright')
    <div style="width: 80px;position: fixed;bottom: 16px;right: 20px;z-index: 10;color:#fff;text-align: center;font-size: 12px;">
    员工通道
        <img class="full-img" src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->errorCorrection('Q')->size('220')->margin(0)->generate($qrCode)) !!}">
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            var url = window.location.href;
            setTimeout(function () {
                window.location.href = url;
            },10000);
        });
    </script>

@endsection
