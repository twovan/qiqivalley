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
<div style="width: 100%;height: 540px">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img class="full-img" src="{{asset('weui/images/web-banner-001.jpg')}}"></div>
            <div class="swiper-slide"><img class="full-img" src="{{asset('weui/images/web-banner-002.jpg')}}"></div>
            <div class="swiper-slide"><img class="full-img" src="{{asset('weui/images/web-banner-003.jpg')}}"></div>
            <div class="swiper-slide"><img class="full-img" src="{{asset('weui/images/web-banner-004.jpg')}}"></div>
            <div class="swiper-slide"><img class="full-img" src="{{asset('weui/images/web-banner-005.jpg')}}"></div>
        </div>
    </div>
</div>
<video  id="myvideo" width="100%" height="auto" controls="controls" > 
                你的浏览器不支持HTML5播放此视频 
        <span style="white-space:pre">    </span><!-- 支持播放的文件格式 --> 
        <source src="{{asset('media/media_1.mp4')}}" type='video/mp4' />  
</video>
<!-- <video id="video" class="video-js vjs-default-skin" controls preload="auto"> -->
    <!-- <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4"> -->
    <!-- <source src="http://vjs.zencdn.net/v/oceans.webm" type="video/webm"> -->
    <!-- <source src="http://vjs.zencdn.net/v/oceans.ogv" type="video/ogg"> -->
    <!-- Tracks need an ending tag thanks to IE9 -->
   <!--  <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p> -->
<!-- </video> -->


    <iframe src="{{url('index/web_store',['id' =>$id])}}" id="iframe1Id" name="iframe1Name" width="100%" height="770" style="display:block;border:0;"></iframe>

@endsection
@section('js')
    <script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            }
        });
    </script>
    <script language="javascript">





        // var vList = ["{{asset('media/media_1.mp4')}}", "{{asset('media/media_2.mp4')}}", "{{asset('media/media_4.mp4')}}" ]; // 初始化播放列表    
        // var vLen = vList.length;   
        // var curr = 0;   

        // var player = videojs('video', { fluid: true }, function () {
        //    console.log('Good to go!');
        //    //this.play(); // if you don't trust autoplay for some reason  
        //    playloop();
        // })

        // player.on('ended', function () {
        //    console.log('结束播放');
        //    playloop();
        // });

        // function playloop() {    
        //     player.src(vList[curr]); 
        //     player.canPlayType("video/mp4");   
        //     player.load();     
        //     player.play();    
        //     curr++;    
        //     console.log('播放视频:第'+curr+"个");
        //     if(curr >= vLen){    
        //         curr = 0; //重新循环播放  
        //         console.log('循环播放结束');
        //     } 
        // }   
       
    </script>    

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
