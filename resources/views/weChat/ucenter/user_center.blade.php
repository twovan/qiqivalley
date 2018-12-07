@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_appmsg user_info">
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">{{$list->wx_name}}</h4>
                        <p class="weui-media-box__desc">欢迎来到奇奇谷</p>
                        @if($list->vip==1)
                          <p class="weui-media-box__desc">您是 <span style="font-weight: bolder;color: #8a1f11">终身会员</span> 含押金:¥ 2000.00 </p>
                        @endif
                        <div class="weui-flex">
                            <div class="weui-flex__item">
                                <div class="placeholder">
                                    <p class="weui-media-box__desc card">
                                        余额：
                                        <i class="fa fa-cny"></i>
                                        <small>{{$list->balance}}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="weui-flex__item">
                                <div class="placeholder">
                                    <p class="weui-media-box__desc card">
                                        门票：
                                        <i class="fa fa-id-card"></i>
                                        <small>{{$list->ticket}} 张</small>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="weui-media-box__hd avatar">
                        <img class="weui-media-box__thumb" src="{{$list->wx_avatar}}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="{{url('wechat/user/memberinfo')}}">
                <div class="weui-cell__bd">会员资料</div>
                <div class="weui-cell__ft">
                    <span class="user_span-ft">查看或修改会员资料</span>
                </div>
            </a>
            <a class="weui-cell weui-cell_access" href="{{url('wechat/history/recharges_list')}}">
                <div class="weui-cell__bd">历史记录</div>
                <div class="weui-cell__ft">
                    <span class="user_span-ft"> 查询借阅或消费信息</span>
                </div>
            </a>
        </div>

        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="{{url('wechat/hairstyle')}}">
                <div class="weui-cell__bd">书籍浏览</div>
                <div class="weui-cell__ft">
                    <span class="user_span-ft">儿童书籍库查看</span>
                </div>
            </a>
        </div>

        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="{{url('wechat/user/edit_phone')}}">
                <div class="weui-cell__bd">手机号</div>
                <div class="weui-cell__ft">@if($list->phone){{$list->phone}}@endif</div>
            </a>
            {{--<a class="weui-cell weui-cell_access" href="#">--}}
            {{--<div class="weui-cell__bd">消费密码</div>--}}
            {{--<span class="user_span-ft fontc-gray"><i class="fa fa-unlock"></i></span>--}}
            {{--</a>--}}

        </div>

        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="tel:13720183482">
                <div class="weui-cell__bd">投诉建议</div>
                <span class="user_span-ft fontc-gray"><i class="fa fa-phone"></i></span>
            </a>
        </div>

        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'center','isworker'=>$isworker])


    </div>
@endsection
