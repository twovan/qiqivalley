<div class="weui-media-box weui-media-box_appmsg evaluate-web">
    <div class="weui-media-box__bd weui-media-box_text">
        <h4 class="weui-media-box__title">验票码
        </h4>
        <div class="weui-media-box__info page__hd">
            <img class="full-img" src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->errorCorrection('Q')->size('310')->margin(0)->generate($qrCode)) !!}">
        </div>
    </div>
</div>
<div class="weui-media-box weui-media-box_appmsg evaluate-web">
    <div class="weui-media-box__bd weui-media-box_text">
        <h4 class="weui-media-box__title">发型精选
            <small>
                <a href="{{url('wechat/hairstyle')}}" class="fontc-black" >查看更多></a>
            </small>
        </h4>
        <p class="weui-media-box__desc">选择一个你喜欢的发型</p>
        <div class="weui-media-box__info">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($hs_lists as $hs_list)
                    <div class=" swiper-slide order-hairstyle-list">
                        <img src="{{asset('storage/'.$hs_list->upload_url)}}">
                        <h5 class="text-center">{{$hs_list->name}}</h5>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
