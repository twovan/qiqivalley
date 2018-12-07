<div class="weui-cell weui-cell_access">
    <div class="weui-cell__bd">合计</div>
    <span class="user_span-ft">￥{{$list->pay_fee}}</span>
</div>
<div class="weui-media-box weui-media-box_appmsg">
    <div class="weui-media-box__bd weui-media-box_text">
        <div class="weui-flex">
            <div class="weui-flex__item order-btn-list">
                <a href="{{url('wechat/store', ['id' => $list->store->id])}}" class="weui-btn weui-btn_mini weui-btn_plain-primary">再来一单</a>
            </div>
            <div class="weui-flex__item order-btn-list">
                <a href="javascript:;" class="weui-btn weui-btn_plain-primary weui-btn_mini weui-btn_plain-disabled">已完成</a>
            </div>
        </div>
    </div>
</div>
