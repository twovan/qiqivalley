<div class="weui-media-box weui-media-box_appmsg">
    <div class="weui-media-box__bd weui-media-box_text">
        <div class="weui-flex">
            <div class="weui-flex__item order-btn-list">
                <a href="{{url('wechat/store', ['id' => $list->store->id])}}" class="weui-btn weui-btn_mini weui-btn_plain-primary">再来一单</a>
            </div>
            <div class="weui-flex__item order-btn-list">
                <a href="{{url('wechat/evaluate/add', ['id' => $list->id])}}" class="weui-btn weui-btn_mini weui-btn_plain-primary">立即评价</a>
            </div>
        </div>
    </div>
</div>