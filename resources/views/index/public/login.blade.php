@extends('backend.layout.app')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="{{ asset('css/softkeys-0.0.1.css') }}" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
    .wrapper-content{
        background-color: #221815 !important;
    }
</style>
<script src="{{ asset('js/softkeys-0.0.1.js') }}"></script>
<!--<div class="big-box text-center loginscreen  animated fadeInDown" style="background-image:url({{asset('weui/images/logo.jpg')}});background-size:20%;">-->
<div class="big-box text-center loginscreen  animated fadeInDown">
    <img src="{{asset('weui/images/login/login-left.png')}}" style="position: absolute;left:-20px;bottom:0;height:1000px;width:340px;"/>
    <div style="margin:auto;" class="text-center">
		<img src="{{asset('weui/images/login/logo-1.png')}}" style="width:300px;margin: 50px 0"/>
        <h2 style="font-weight: bolder;color: #fff;">历史发型查询</h2>
        <form class="m-t" method="post" id="form-validate-submit">
            {{ csrf_field() }}
            <div id="psw_invisible" class="form-group">
                <div class="input-group" style="width: 650px;margin:auto;height: 70px;">
                    <input id="input_invisible" type="password" style="font-size: 40px;height: 70px;width: 600px;" maxlength="11" name="phone" class="form-control" placeholder="请输入手机号码">
                    <i class="fa fa-eye fa-2x" style="position: absolute;right: 60px;top: 20px;z-index: 9999" onclick="showPsw()"></i>
                </div>
            </div>
             <div id="psw_visible" class="form-group" style="display: none;">
                <div class="input-group" style="width: 650px;margin:auto;height: 70px;">
                    <input id="input_visible" type="text" style="font-size: 40px;height: 70px;width: 600px;" maxlength="11" name="phone" class="form-control" placeholder="请输入手机号码">
                    <i class="fa fa-eye-slash fa-2x" style="position: absolute;right: 60px;top: 20px;z-index: 9999" onclick="hidePsw()"></i>
                </div>
            </div>
			<div class="softkeys" data-target="input[name='phone']"></div>
            <input type="submit" style="margin: auto;width: 300px;height: 100px;font-size: 60px;" value="查&nbsp;&nbsp;&nbsp;&nbsp;询"></input>
            <br/>
            <img src="{{asset('weui/images/login/logo-2.png')}}" style="width:300px;margin-top: 100px;"/>

    </div>
    <img src="{{asset('weui/images/login/login-right.png')}}" style="position: absolute;right: -20px;bottom:0;height: 1000px;width:340px;"/>

</div>

@endsection

<!--    js    -->
@section('js_code')
<script type="text/javascript">

    $(function () {
        var form_url = '{{route('index.loginPost')}}';   
        var index_url = '{{route('index.index')}}';
        var rules = [];
        subActionAjaxValidateForMime('#form-validate-submit', rules, form_url, index_url);
    });

</script>
<script>
	$(document).ready(function(){
			$('.gohome').hide();
            $('.softkeys').softkeys({
                target : $('.softkeys').data('target'),
                layout : [
        			['7','8','9', ],
                    ['4','5','6'],
                        ['1','2','3'],
                        ['clean','0','delete'],  
                ]
            });
        });
</script>
<script>
    // 这里使用最原始的js语法实现，可对应换成jquery语法进行逻辑控制
    var visible = document.getElementById('psw_visible');//text block
    var invisible = document.getElementById('psw_invisible');//password block
    var inputVisible = document.getElementById('input_visible');
    var inputInVisible = document.getElementById('input_invisible');




    input_invisible.addEventListener("keyup", function(event) {
         var val = inputInVisible.value;//将password的值传给text
         inputVisible.value = val;
         //alert(123);
    });


    //隐藏text block，显示password block
    function showPsw() {
        var val = inputInVisible.value;//将password的值传给text
        inputVisible.value = val;
        invisible.style.display = "none";
        visible.style.display = "";
    }
    //隐藏password，显示text
    function hidePsw() {
        var val = inputVisible.value;//将text的值传给password
        inputInVisible.value = val;
        invisible.style.display = "";
        visible.style.display = "none";
    }

</script>
<script>
        $(function () {
            var url = window.location.href;
            setTimeout(function () {
                window.location.href = url;
            },100000);
        });
    </script>

@endsection
