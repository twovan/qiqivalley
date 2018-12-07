<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @section('title')
        @show
    </title>
    <link rel="stylesheet" href="{{asset('weui/lib/weui.css')}}"/>
    <link rel="stylesheet" href="{{asset('weui/css/example.css')}}"/>
    <link rel="stylesheet" href="{{asset('weui/lib/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('weui/lib/swiper.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('weui/css/base.css')}}"/>
    @section('css')
    @show
</head>
<body ontouchstart>
<div class="weui-toptips weui-toptips_warn js_tooltips">错误提示</div>
<div class="container">

@yield('body')

</div>
<script type="text/javascript" src="{{asset('weui/lib/jquery-1.12.4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('weui/lib/jweixin-1.2.0.js')}}"></script>
<script type="text/javascript" src="{{asset('weui/lib/swiper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('weui/lib/weui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('weui/lib/zepto.min.js')}}"></script>
<script type="text/javascript" src="{{asset('weui/js/jqForZy.js')}}"></script>
@section('js')
@show
</body>
</html>