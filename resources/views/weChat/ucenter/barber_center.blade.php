@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_appmsg user_info">
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">{{$list->wx_name}}</h4>
                        <p class="weui-media-box__desc">@if($list->work_no)工号{{$list->work_no}} @endif 祝您工作顺利</p>
                        <p class="weui-media-box__desc card">@if($get_work) {{$get_work->store->name}} @endif <small>{{date('Y-m-d')}}</small></p>
                    </div>
                    <div class="weui-media-box__hd avatar">
                        <img class="weui-media-box__thumb" src="{{$list->wx_avatar}}">
                    </div>
                </div>
            </div>
        </div>

        {{--<!--<div class="weui-cells">--}}
            {{--@if($get_work && $get_work->status > 0)--}}
                {{--<a class="weui-cell weui-cell_access" href="javascript:;">--}}
                    {{--<div class="weui-cell__bd">上班时间</div>--}}
                    {{--<span class="user_span-ft fontc-gray">--}}
                        {{--{{$get_work->start_at}} <i class="fa fa-check-circle-o"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--@else--}}
                {{--<a id="work_start" class="weui-cell weui-cell_access" href="javascript:;">--}}
                    {{--<div class="weui-cell__bd">上班时间</div>--}}
                    {{--<span class="user_span-ft fontc-gray">--}}
                    {{--去打卡 <i class="fa fa-qrcode"></i>--}}
                {{--</span>--}}
                {{--</a>--}}
            {{--@endif--}}
            {{--@if($get_work && $get_work->status == 2)--}}
                {{--<a class="weui-cell weui-cell_access" href="javascript:;">--}}
                    {{--<div class="weui-cell__bd">下班时间</div>--}}
                    {{--<span class="user_span-ft fontc-gray">--}}
                    {{--{{$get_work->end_at}} <i class="fa fa-check-circle-o"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
                {{--@else--}}
                {{--<a id="work_end" class="weui-cell weui-cell_access" href="javascript:;">--}}
                    {{--<div class="weui-cell__bd">下班时间</div>--}}
                    {{--<span class="user_span-ft fontc-gray">--}}
                    {{--去打卡 <i class="fa fa-qrcode"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
            {{--@endif--}}
        {{--</div> -->--}}

        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="{{url('wechat/course/addcourseinfo')}}">
                <div class="weui-cell__bd">增加课程记录</div>
                <div class="weui-cell__ft"></div>
            </a>
        </div>

         <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="{{url('wechat/course/courseinfo')}}">
                <div class="weui-cell__bd">查询课程记录</div>
                <div class="weui-cell__ft"></div>
            </a>
        </div>


        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="tel:13607166059">
                <div class="weui-cell__bd">技术支持</div>
                <span class="user_span-ft fontc-gray"><i class="fa fa-phone"></i></span>
            </a>
            <a class="weui-cell weui-cell_access" href="{{url('wechat/user/edit_phone')}}">
                <div class="weui-cell__bd">手机号</div>
                <div class="weui-cell__ft">@if($list->phone){{$list->phone}}@endif</div>
            </a>
        </div>

        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'worker','isworker'=>$isworker])
    </div>
@endsection

@section('js')
    <script type="text/javascript" charset="utf-8">
        wx.config({!! $app->jssdk->buildConfig(array('chooseImage','uploadImage'), env('WECHAT_DEBUG')) !!});
        $(function () {
            $('#work_start').click(function () {
                @if(!$get_work)
                    weui.alert('请先关联门店');
                    return false;
                @endif
                wx.chooseImage({
                    count: 1, // 默认9
                    sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['camera'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (choose_res) {
                        if(choose_res.errMsg == 'chooseImage:ok'){
                            wx.uploadImage({
                                localId: choose_res.localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                                isShowProgressTips: 1, // 默认为1，显示进度提示
                                success: function (up_res) {
                                    if(up_res.errMsg == 'uploadImage:ok'){
                                        var form_url = '{{url('wechat/user/barberWork')}}';
                                        var jump_url = '{{url('wechat/user')}}';
                                        var data = {
                                            media_id:up_res.serverId,
                                            status:1
                                        };
                                        subActionAjaxForMime(form_url, data, jump_url);
                                    }
                                }
                            });
                        }
                    }
                });
            });
            $('#work_end').click(function () {
                @if(!$get_work)
                    weui.alert('请先关联门店');
                    return false;
                @endif
                @if($no_finish_count)
                    weui.alert('您还有未完成的订单哦');
                    return false;
                @endif
                wx.chooseImage({
                    count: 1, // 默认9
                    sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['camera'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (choose_res) {
                        if(choose_res.errMsg == 'chooseImage:ok'){
                            wx.uploadImage({
                                localId: choose_res.localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                                isShowProgressTips: 1, // 默认为1，显示进度提示
                                success: function (up_res) {
                                    if(up_res.errMsg == 'uploadImage:ok'){
                                        var form_url = '{{url('wechat/user/barberWork')}}';
                                        var jump_url = '{{url('wechat/user')}}';
                                        var data = {
                                            media_id:up_res.serverId,
                                            status:2
                                        };
                                        subActionAjaxForMime(form_url, data, jump_url);
                                    }
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
    @endsection
