@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd">
        <div class="weui-panel">
            <div class="weui-panel__hd">服务评价</div>
            <div class="weui-panel__bd">
                @foreach($evaluate_lists as $evaluate_list)
                <div class="weui-media-box weui-media-box_appmsg evaluate-web">
                    <div class="weui-media-box__hd img32">
                        <img class="weui-media-box__thumb" src="{{$evaluate_list->customer->wx_avatar}}" alt="">
                    </div>
                    <div class="weui-media-box__bd weui-media-box_text">
                        <div class="weui-media-box__title">
                            <h4 class="weui-media-box__title title_name fz15">{{$evaluate_list->customer->wx_name}}</h4>
                            <small>{{$evaluate_list->created_at}}</small>
                        </div>
                        <p class="weui-media-box__desc">{{$evaluate_list->content}}</p>
                        <ul class="weui-media-box__info">
                            <li class="weui-media-box__info__meta">{{$evaluate_list->order->service->name}}</li>
                            <li class="weui-media-box__info__meta weui-media-box__info__meta_extra star">
                                @for($i = 0; $i < $evaluate_list->star; $i++)
                                    <i class="fa fa-star checked"></i>
                                @endfor
                                @for($i = 0; $i < (5 - $evaluate_list->star); $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @include('weChat.layout.copyright')
    </div>
@endsection
