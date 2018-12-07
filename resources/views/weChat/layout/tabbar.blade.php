<div class="footer-weui-tab">
    <div class="weui-tab">
        <div class="weui-tabbar">
            @if($isworker)
                <a href="{{url('wechat/user/barber_center')}}"
                   class="weui-tabbar__item @if($on == 'worker') weui-bar__item_on @endif">
                    <div class="weui-tabbar__icon"><i class="fa fa-meh-o"></i></div>
                    <p class="weui-tabbar__label">员工中心</p>
                </a>
            @else
                <a href="{{url('wechat/index')}}"
                   class="weui-tabbar__item @if($on == 'index') weui-bar__item_on @endif">
                    <div class="weui-tabbar__icon"><i class="fa fa-home"></i></div>
                    <p class="weui-tabbar__label">店铺列表</p>
                </a>
            @endif
            <a href="{{url('wechat/user')}}"
               class="weui-tabbar__item @if($on == 'center') weui-bar__item_on @endif">
                <div class="weui-tabbar__icon"><i class="fa fa-user"></i></div>
                <p class="weui-tabbar__label">会员中心</p>
            </a>
        </div>
    </div>
</div>