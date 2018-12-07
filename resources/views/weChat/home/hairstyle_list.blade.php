@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <style>
        /* css样式 */
        body {
            background: #e5e5e5;
        }

        /* 瀑布流最外层 */
        #root {
            margin: 0 auto;
            /*width: 100%;*/
            column-count: 2;
            /*column-width: 100px;*/
            column-gap: 10px;
            padding-bottom: 20px;
        }

        #root > :first-child {
            /*margin-top: 10px;*/
        }

        /* 每一列图片包含层 */
        .item {
            margin-bottom: 10px;
            /* 防止多列布局，分页媒体和多区域上下文中的意外中断 */
            break-inside: avoid;
            background: #fff;
            padding: 10px 10px 20px 10px;
            display: block;
        }

        .item:hover {
            box-shadow: 1px 1px 1px rgba(0, 0, 0, .5);
        }

        /* 图片 */
        .itemImg {
            width: 100%;
            vertical-align: middle;
        }

        /* 图片下的信息包含层 */
        .userInfo {
            padding: 5px 10px;
            text-align: center;
        }

        .avatar {
            vertical-align: middle;
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        .username {
            margin-left: 5px;
            text-shadow: 2px 2px 2px rgba(0, 0, 0, .3);
            font-size: 10px;
        }
    </style>
    <div class="page__bd">
        <div class="weui-cells order_title">
            <div class="weui-flex">
                <div class="weui-flex__item">
                    <a class="weui-cell weui-cell_access @if($type == 1) active @endif"
                       href="{{url('wechat/hairstyle')}}?type=1">儿童绘本</a>
                </div>
                <div class="weui-flex__item">
                    <a class="weui-cell weui-cell_access @if($type == 2) active @endif"
                       href="{{url('wechat/hairstyle')}}?type=2">英文绘本</a>
                </div>
                <div class="weui-flex__item">
                    <a class="weui-cell weui-cell_access @if($type == 3) active @endif"
                       href="{{url('wechat/hairstyle')}}?type=3">大人读物</a>
                </div>
            </div>
        </div>

        <div class="weui-grids">
            <div id="root">
                @foreach($lists as $list)
                    <div class="item">
                        <img class="itemImg" src="{{asset('storage/'.$list->upload_url)}}">
                        <div class="userInfo">
                            {{--<img class="avatar" src="../images/gift.png" alt=""/>--}}
                            <span class="username">《{{$list->name}}》</span>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>

        @include('weChat.layout.copyright')
    </div>

    @include('weChat.layout.tabbar',['on' => 'center','isworker'=>$isworker])
@endsection
@section('js')
    <script>
        $(function () {
            $('.weui-grid').click(function () {
                var img = $(this).find('img').attr('src');
                $('.weui-gallery').css('display', 'block').find('.weui-gallery__img').attr('style', 'background-image:url(' + img + ')');
            });
            $('.weui-gallery').click(function () {
                $('.weui-gallery').css('display', 'none');
            });

        })

    </script>
@endsection
