<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>上传照片</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->

    <link rel="shortcut icon" href="/favicon.ico">
    <link href="{{ asset('backend/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/font-awesome.min93e3.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/style.min.css?v=4.1.0') }}" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" style="right: 0;" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="navbar-minimalize">
                        <div class="logo-element">
                            <i class="fa fa-bars"></i>
                        </div>
                        <div class="profile-element" style="width: 64px;height: 64px;">
                            <img alt="image" class="img-circle img100per" style="width: 100%;" src="{{$user['wx_avatar']}}"/>
                        </div>
                    </div>
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs"><strong class="font-bold">{{$user['wx_name']}}</strong></span>
                            </span>
                        </a>
                    </div>
                </li>

                @include('index.layout.left')

            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->

    <a class="navbar-minimalize hide" href="#"></a>
    <!--右侧部分开始-->
    <div id="page-wrapper" style="margin:0 220px 0 0" class="gray-bg dashbard-1">
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="{{route('index.base')}}">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight" style="right: 180px;">
                <i class="fa fa-forward"></i>
            </button>
            <button id="page-refresh-mime" class="roll-nav roll-right" style="right: 140px;">
                <i class="fa fa-refresh"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a></li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                </ul>
            </div>
            <a href="{{route('index.logout')}}" class="roll-nav roll-right J_tabExit"><i class="fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe" width="100%" height="100%" src="{{route('index.base')}}"
                    frameborder="0" data-id="{{ route('index.base') }}" seamless></iframe>
        </div>
    </div>
    <!--右侧部分结束-->

</div>

<script src="{{ asset('backend/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('backend/js/bootstrap.min.js?v=3.3.6') }}"></script>
<script src="{{ asset('backend/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('backend/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('backend/plugins/layer/layer.min.js') }}"></script>
<script src="{{ asset('backend/js/hplus.min.js?v=4.1.0') }}"></script>
<script src="{{ asset('backend/js/contabs.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pace/pace.min.js') }}"></script>
</body>

<!-- Mirrored from www.zi-han.net/theme/hplus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:17:11 GMT -->
</html>