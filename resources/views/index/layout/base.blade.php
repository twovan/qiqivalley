@extends('backend.layout.app')
@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-center p-md">
                <h1 style="font-size: 100px;margin-top: 400px;">欢迎 <span class="text-navy">{{$user['wx_name']}}</span></h1>
                <p style="font-size: 30px;">
                    操作完毕后请及时退出。
					<span id="time">3</span>秒钟自动跳到订单页
                </p>
            </div>
        </div>
    </div>
	<a href="{{route('index.order.index')}}" style="display:none;">返回</a>
	<script>
	$(function () {
 
      setTimeout(ChangeTime, 1000);
 
    });
 
    function ChangeTime() {
 
      var time;
 
      time = $("#time").text();    
 
      time = parseInt(time);
 
      time--;
 
      if (time <= 0) {
 
        window.location.href = "{{route('index.order.index')}}";
 
      } else {
 
        $("#time").text(time);
 
        setTimeout(ChangeTime, 1000);
 
      }
 
    }
	</script>
@endsection