@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd lh0">
        <img class="full-img" src="{{asset('storage/'.$list->upload_url)}}">
    </div>
    <div class="page__bd page__bd_footer">
        <div class="weui-panel__bd bgc-white">
            <div class="weui-media-box weui-media-box_text">
                <h4 class="weui-media-box__title">{{$list->name}}</h4>
                <p class="weui-media-box__desc">{{$list->address}}</p>
            </div>
        </div>
        <div class="weui-panel">
            <div class="weui-panel__hd">可提供以下服务</div>
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_small-appmsg">
                    <div class="weui-cells">
                        @foreach($service_lists as $service_list)
                            <a id="{{$service_list->id}}" class="weui-cell weui-cell_access pay" href="#">
                                <div class="weui-media-box_text weui-cell__bd weui-cell_primary">
                                    <h4 class="weui-media-box__title">{{$service_list->name}}</h4>
                                    <p class="weui-media-box__desc">{{$service_list->remark}}</p>
                                </div>
                            <!-- <span class="weui-cell__ft fz15">￥{{$service_list->price}}</span> -->
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="weui-panel">--}}
            {{--<div class="weui-panel__hd">服务评价</div>--}}
            {{--<div class="weui-panel__bd">--}}
                {{--@if($evaluate_lists)--}}
                    {{--@foreach($evaluate_lists as $evaluate_list)--}}
                        {{--<div class="weui-media-box weui-media-box_appmsg evaluate-web">--}}
                            {{--<div class="weui-media-box__hd img32">--}}
                                {{--<img class="weui-media-box__thumb" src="{{$evaluate_list->customer->wx_avatar}}" alt="">--}}
                            {{--</div>--}}
                            {{--<div class="weui-media-box__bd weui-media-box_text">--}}
                                {{--<div class="weui-media-box__title">--}}
                                    {{--<h4 class="weui-media-box__title title_name fz15">{{$evaluate_list->customer->wx_name}}</h4>--}}
                                    {{--<small>{{$evaluate_list->created_at}}</small>--}}
                                {{--</div>--}}
                                {{--<p class="weui-media-box__desc">{{$evaluate_list->content}}</p>--}}
                                {{--<ul class="weui-media-box__info">--}}
                                    {{--<li class="weui-media-box__info__meta">{{$evaluate_list->order->service->name}}</li>--}}
                                    {{--<li class="weui-media-box__info__meta weui-media-box__info__meta_extra star">--}}
                                        {{--@for($i = 0; $i < $evaluate_list->star; $i++)--}}
                                            {{--<i class="fa fa-star checked"></i>--}}
                                        {{--@endfor--}}
                                        {{--@for($i = 0; $i < (5 - $evaluate_list->star); $i++)--}}
                                            {{--<i class="fa fa-star"></i>--}}
                                        {{--@endfor--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                {{--@else--}}
                    {{--无--}}
                {{--@endif--}}
            {{--</div>--}}
            {{--@if($evaluate_lists)--}}
                {{--<div class="weui-panel__ft">--}}
                    {{--<a href="{{url('wechat/store/evaluate_list',['id' => $list->id])}}"--}}
                       {{--class="weui-cell weui-cell_access weui-cell_link">--}}
                        {{--<div class="weui-cell__bd">查看全部</div>--}}
                        {{--<span class="weui-cell__ft"></span>--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--@endif--}}
        {{--</div>--}}

        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'index','isworker'=>false])
    </div>
@endsection
@section('js')
    {{--<script type="text/javascript" charset="utf-8">--}}
        {{--$(document).on("click", '.pay', function () {--}}
            {{--@if(empty($get_user->phone))--}}
            {{--weui.alert('请先绑定手机号');--}}
            {{--//weui.alert(this.id);--}}
            {{--setTimeout("location.href='http://qqg.twovan.cn/wechat/user/edit_phone?sid=" + this.id + "'", 1000);--}}
            {{--return false;--}}
            {{--@endif--}}
        {{--});--}}
    {{--</script>--}}
@endsection