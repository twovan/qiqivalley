@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd weui-media-box_text">
                <h4 class="weui-media-box__title fontc-black">课程记录</h4>
                <p class="weui-media-box__desc">查询自己的课程记录</p>
            </div>
            <div id="courselist" class="weui-panel__bd">
                @if(collect($list)->isEmpty())
                    <div class="weui-media-box weui-media-box_appmsg evaluate-web">
                        <h4>暂无记录</h4>
                    </div>
                    @else
                    @foreach($list as $course)
                    <div class="weui-media-box weui-media-box_appmsg evaluate-web">
                        <div class="weui-media-box__hd">
                            <img class="weui-media-box__thumb" src="{{asset('weui/images/pic_160.png')}}">
                        </div>
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title">{{$course->courses_name}}</h4>
                            <p class="weui-media-box__desc">上课时间：{{$course->courses_ts}}</p>
                            <p class="weui-media-box__desc">任课老师：{{$course->user->name}}</p>
                            <p class="weui-media-box__desc">上课人数：{{$course->courses_num}}人</p>
                            <p class="weui-media-box__desc">
                                耗材使用：
                                <?php

                                    $details = '';
                                    $materialdetails = $course->materialdetail;
                                    foreach ($materialdetails as $itmes){
                                        $material_id = $itmes->material_id;
                                        $num  = $itmes->num;
                                        $material_name = $material_arr[$material_id];
                                        $details .= $material_name.'*'.$num.'、';
                                     }

                                    echo trim($details,'、');
                                ?>

                            </p>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>

        </div>


        @include('weChat.layout.copyright')
        @include('weChat.layout.tabbar',['on' => 'worker','isworker'=>true])
    </div>
@endsection

@section('js')
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            spaceBetween: 12,
            freeMode: true,
            pagination: {
                clickable: true
            }
        });
    </script>
    @endsection
