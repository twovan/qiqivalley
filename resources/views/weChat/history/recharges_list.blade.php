@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <style type="text/css">
        .order_title a {
            font-size: 14px !important
        }
    </style>
    <div class="page__bd page__bd_footer">
        <div class="weui-cells order_title">
            <div class="weui-flex">
                <div class="weui-flex__item">
                    {{--<a class="weui-cell weui-cell_access @if($request_status == 0) active @endif" href="{{url('wechat/order')}}?status=0">充值记录</a>--}}
                    <a class="weui-cell weui-cell_access active"
                       href="{{url('wechat/history/recharges_list')}}">充值记录</a>
                </div>
                <div class="weui-flex__item">
                    {{--<a class="weui-cell weui-cell_access @if($request_status == 1) active @endif" href="{{url('wechat/order')}}?status=1">消费记录</a>--}}
                    <a class="weui-cell weui-cell_access" href="{{url('wechat/history/costs_list')}}">消费记录</a>

                </div>
                <div class="weui-flex__item">
                    {{--<a class="weui-cell weui-cell_access @if($request_status == 2) active @endif" href="{{url('wechat/order')}}?status=2">借阅记录</a>--}}
                    <a class="weui-cell weui-cell_access" href="{{url('wechat/history/borrows_list')}}">借阅记录</a>

                </div>
            </div>
        </div>
        @if(collect($list)->isEmpty())

            <div class="weui-panel weui-panel_access order_list">
                <div class="weui-panel__hd weui-panel__bd text-center">
                    <i class="fa fa-5x fa-circle-o-notch fa-spin" style="margin:50px auto 30px auto"></i>

                    <h4 style="margin-bottom: 30px">暂无充值记录</h4>
                </div>
            </div>

        @else
            @foreach($list as $lists)
                <div class="weui-panel weui-panel_access order_list">

                    <div class="weui-panel__hd weui-panel__bd">
                        <a href="#" class="weui-media-box weui-media-box_appmsg evaluate-web">
                            <div class="weui-media-box__hd">
                                <img class="weui-media-box__thumb" src="{{asset('weui/images/pic_160.png')}}" alt="">
                            </div>


                            <div class="weui-media-box__bd">
                                <h4 class="weui-media-box__title">充值 丨 ¥ {{$lists->amount}} | 门票 {{$lists->ticket_num}}
                                    张</h4>
                                <p class="weui-media-box__desc">充值门店：@if(collect($lists->store)->isNotEmpty()){{$lists->store->name}}@endif</p>
                                <p class="weui-media-box__desc">充值时间：{{$lists->recharge_ts}}</p>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">当时余额：¥ {{$lists->last_balance or '0.00'}}</li>
                                    <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">
                                        剩余门票：{{$lists->last_ticket or '0'}}张
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
                    <div class="weui-panel__hd pull-right">
                        结余 ￥{{$lists->amount+$lists->last_balance}} | 门票 {{$lists->ticket_num+$lists->last_ticket}}张
                    </div>
                </div>
            @endforeach
        @endif

        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'center','isworker'=>false])
    </div>
@endsection
