@extends('weChat.layout.app')
<link href="http://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">
<!-- If you'd like to support IE8 -->
<script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js" type="javascript"></script>
<style type="style">
body {
    //-webkit-transform: rotate(90deg);
}
</style>
@section('body')
<video  id="myvideo" width="100%" height="auto" controls="controls" > 
                你的浏览器不支持HTML5播放此视频 
        <span style="white-space:pre">    </span><!-- 支持播放的文件格式 --> 
        <source src="{{asset('media/media_1.mp4')}}" type='video/mp4' />  
</video>

@endsection
@section('js')
    <script src="http://vjs.zencdn.net/6.6.3/video.js"></script>

 
    <script language="javascript">   
        var vList = ["{{asset('media/media_4.mp4')}}", "{{asset('media/media_1.mp4')}}"]; // 初始化播放列表    
        var vLen = vList.length;  
        var curr = 0;  
        var video = document.getElementById("myvideo");   

        $(document).ready(function(){ 
             //video.play();   
             playloop();
        }); 
           
       
        video.addEventListener('ended', function(){ 
            console.log('第'+curr+'个视屏播放结束');
            playloop(); 
        });   
            
        function playloop() {   
            video.src = vList[curr];   
            video.load();    
            video.play();   
            curr++;
            console.log('播放视频:第'+curr+"个");   
            if(curr >= vLen){   
                curr = 0; //重新循环播放 
                console.log('循环播放结束');
            }   
             
        }   
    </script>   
@endsection
