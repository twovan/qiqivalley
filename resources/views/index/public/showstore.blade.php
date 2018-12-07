@extends( 'weChat.layout.app' )
@section( 'title', $title_name )
	<link href="http://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">
	<!-- If you'd like to support IE8 -->
	<script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js" type="javascript"></script>
<style type="style">
	body { //-webkit-transform: rotate(90deg); }
</style>
@section( 'body' )
	<div style="width: 100%;height: 1260px">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide"><img class="full-img" src="{{asset('weui/images/web-banner-01.jpg')}}">
				</div>
				<div class="swiper-slide"><img class="full-img" src="{{asset('weui/images/web-banner-02.jpg')}}">
				</div>
			</div>
		</div>
	</div>
<iframe src="{{url('index/web_store',['id' =>$id])}}" id="iframe1Id" name="iframe1Name" width="100%" height="660" style="display:block;border:0;"></iframe> @endsection @section('js')
<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
<script>
	var swiper = new Swiper( '.swiper-container', {
		autoplay: {
			delay: 5000,
			disableOnInteraction: false
		}
	} );
</script>
@endsection