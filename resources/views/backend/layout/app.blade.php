<!DOCTYPE html>
<html>

<!-- Mirrored from www.zi-han.net/theme/hplus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:16:41 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>奇奇谷微信后台管理系统</title>
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
    <link rel="shortcut icon" href=" /favicon.ico" />
    <link href="{{asset('backend/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('backend/css/font-awesome.min93e3.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('backend/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/footable/footable.core.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/icheck-flat/blue.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/chosen/chosen.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <!--加载不同页面的css插件-->
    @section('css_code')
    @show
    <link href="{{asset('backend/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/unicorn.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/mend.mime.css')}}" rel="stylesheet">

    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
</head>

<body class="fixed-sidebar full-height-layout gray-bg">
<div class="wrapper-content animated fadeInRight" style="padding: 20px; background-color: #fff; min-height: 100%">
    @yield('content')
</div>

<script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('backend/js/content.min.js')}}"></script>
<script src="{{asset('backend/plugins/icheck-flat/jquery.icheck.min.js')}}"></script>
<script src="{{asset('backend/plugins/icheck-flat/select2.min.js')}}"></script>
{{--    <script src="{{asset('backend/plugins/dataTables/jquery.dataTables.js')}}"></script>--}}
<script src="{{asset('backend/plugins/footable/footable.all.min.js')}}"></script>
<script src="{{asset('backend/plugins/validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('backend/plugins/validate/messages_zh.min.js')}}"></script>
<script src="{{asset('backend/plugins/chosen/chosen.jquery.js')}}"></script>
<script src="{{asset('backend/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('backend/plugins/layer/laydate/laydate.js')}}"></script>
<script src="{{asset('backend/js/jquery.common.mime.js')}}"></script>
<!--加载不同页面的js插件-->
@section('js_code')
@show

</body>
</html>