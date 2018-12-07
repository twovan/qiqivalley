@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">
                <div class="page__bd lh0">
                    <img class="full-img" src="{{asset('weui/images/wechat-banner-001.png')}}">
                </div>
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_text">
                        <h4 class="weui-media-box__title fontc-black">所有的门店</h4>
                        <p class="weui-media-box__desc">为您精选的门店</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                @foreach($lists as $list)
                <div class="weui-media-box weui-media-box_text">
                    <a href="{{url('wechat/store',['id' => $list->id])}}">
                        <div class="page__bd lh0">
                            <img class="full-img br10" src="{{asset('storage/'.$list->upload_url)}}">
                        </div>
                        <h4 class="weui-media-box__title fontc-black">{{$list->name}}</h4>
                        <p class="weui-media-box__desc">
                            <i class="fa fa-map-marker "></i>
                            {{$list->address}}
                        </p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'index'])
    </div>
@endsection
