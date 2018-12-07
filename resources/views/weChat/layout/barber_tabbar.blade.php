@extends('weChat.layout.app')
<div class="footer-weui-tab">
    <div class="weui-tab">
        <div class="weui-tabbar">
            <a href="{{url('user/barder_center')}}"
               class="weui-tabbar__item @if($on == 'center') weui-bar__item_on @endif">
                <div class="weui-tabbar__icon"><i class="fa fa-meh-o"></i></div>
                <p class="weui-tabbar__label">员工中心</p>
            </a>
            <a href="{{url('user/user_center')}}" class="weui-tabbar__item @if($on == 'index') weui-bar__item_on @endif">
                <div class="weui-tabbar__icon"><i class="fa fa-user"></i></div>
                <p class="weui-tabbar__label">个人中心</p>
            </a>

        </div>
    </div>
</div>
