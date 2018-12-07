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
                        <img class="weui-media-box__thumb" src="{{asset('storage/'.$list->service->upload_url)}}" alt="">
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
                @if($list->status == 1)
                    @include('weChat.order.info_01')
                @elseif($list->status == 2)
                    @include('weChat.order.info_02')
                @elseif($list->status == 3)
                    @include('weChat.order.info_03')
                @endif

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
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            spaceBetween: 12,
            freeMode: true,
            pagination: {
                clickable: true
            }
        });
    </script>
    @endsection
