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
                    <a class="weui-cell weui-cell_access" href="{{url('wechat/history/recharges_list')}}">充值记录</a>
                </div>
                <div class="weui-flex__item">
                    {{--<a class="weui-cell weui-cell_access @if($request_status == 1) active @endif" href="{{url('wechat/order')}}?status=1">消费记录</a>--}}
                    <a class="weui-cell weui-cell_access" href="{{url('wechat/history/costs_list')}}">消费记录</a>

                </div>
                <div class="weui-flex__item">
                    {{--<a class="weui-cell weui-cell_access @if($request_status == 2) active @endif" href="{{url('wechat/order')}}?status=2">借阅记录</a>--}}
                    <a class="weui-cell weui-cell_access active" href="{{url('wechat/history/borrows_list')}}">借阅记录</a>

                </div>
            </div>
        </div>
        @if(collect($list)->isEmpty())
            <div class="weui-panel weui-panel_access order_list">
                <div class="weui-panel__hd weui-panel__bd text-center">
                    <i class="fa fa-5x fa-circle-o-notch fa-spin" style="margin:50px auto 30px auto"></i>

                    <h4 style="margin-bottom: 30px">暂无借阅记录</h4>
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
                                <h4 class="weui-media-box__title">{{$lists->b_name}}</h4>
                                <p class="weui-media-box__desc">借阅门店：{{$lists->store->name}}</p>
                                <p class="weui-media-box__desc">借阅时间：{{$lists->borrow_ts}}</p>
                                @if(!empty($lists->back_ts))
                                    <p class="weui-media-box__desc">归还时间：{{$lists->back_ts}}</p>
                                @endif

                                <ul class="weui-media-box__info pull-right">
                                    <?php
                                    $data1 = strtotime(date('Y-m-d', strtotime($lists->borrow_ts)));

                                    $data2 = empty($lists->back_ts) ? strtotime(date('Y-m-d')) : strtotime(date('Y-m-d', strtotime($lists->back_ts)));

                                    $day = ($data2 - $data1) / (24 * 3600);

                                    ?>
                                    @if(!empty($lists->back_ts))
                                        <li class="weui-media-box__info__meta">共借时间：<?php echo $day; ?>天</li>
                                    @else
                                        <li class="weui-media-box__info__meta">已借时间：<?php echo $day; ?>天</li>
                                    @endif

                                    <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">
                                        @if(!empty($lists->back_ts))
                                            <span style="color: green">已归还</span>
                                        @else
                                            <span style="color: red">未归还</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif

        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'center','isworker'=>false])
    </div>
@endsection
