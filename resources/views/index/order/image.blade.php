@extends('backend.layout.app')
@section('css_code')
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="{{asset('backend/plugins/webuploader/webuploader.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/webuploader/webuploader-demo.min.css')}}" rel="stylesheet">
	<style>    
	.one {    
	    margin: 0 auto;    
	    /*height: 140px;    */
	    writing-mode: vertical-lr;/*从左向右 从右向左是 writing-mode: vertical-rl;*/    
	    writing-mode: tb-lr;/*IE浏览器的从左向右 从右向左是 writing-mode: tb-rl；*/    
	    margin-top: 100px;
	}    
	canvas{
		margin: 5px auto;
	}
	</style>    
@endsection
@section('content')

    <div class="row" style="display:none;">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">

                <div class="ibox-title clearfix">
                    <h5>{{$list_title_name}}
                        <small>请选择您的图片，支持批量上传，最多上传5张，单张图片不得大于2MB</small>
                    </h5>
                    <div class="pull-right">
                        <a href="{{route('index.order.index')}}" class="btn btn-info btn-xs">返回</a>
                    </div>
                </div>
                <div class="ibox-content" style="display:none;">
                    <div class="page-container">
                        <div id="uploader" class="wu-example">
                            <div class="queueList">
                                <div id="dndArea" class="placeholder">
                                    <div id="filePicker"></div>
                                    <p>或将照片拖到这里</p>
                                </div>
                            </div>
                            <div class="statusBar" ">
                                <div class="progress">
                                    <span class="text">0%</span>
                                    <span class="percentage"></span>
                                </div>
                                <div class="info"></div>
                                <div class="btns">
                                    <div id="filePicker2"></div>
                                    <div class="uploadBtn">开始上传</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col-sm-12">
				<div class="ibox widget-box float-e-margins">

					<div class="ibox-title clearfix" style="padding: 10px 15px !important;">
						<h5>{{$list_title_name}}
							<small>请拍摄您发型的图片，记录您的发型，每次上传三个角度的照片，单张照片不得大于2MB</small>
						</h5>
					</div>
					<div class="ibox-content">
						<div class="page-container">
							
							<div class="col-sm-7">
								<video id="video" width="1920" height="1080" controls></video>
								<br>
								<a href="{{route('index.order.index')}}" style="width: 340px;height: 180px;font-size:100px;margin-top: 20px;line-height: 150px;" class="btn btn-primary btn-lg">返回</a>
								<button id="ctlBtn1" style="width: 340px;height: 180px;font-size:100px;margin-top: 20px;float: right;line-height: 150px;" class="btn btn-primary btn-lg">上传</button>
								<!-- <a href="{{route('index.logout')}}" style="width: 340px;height: 180px;font-size:100px;margin-top: 20px;line-height: 150px;float: right;" class="btn btn-primary btn-lg">退出</a> -->
							</div>
							<div class="col-sm-1">
								
					
							</div>
							<div class="col-sm-5">
								
								<div class="col-sm-3">
									<h2 class="one" style="margin-top: 70px;">「正面」轻触拍照</h2>
									<br>
									<h2 class="one" style="margin-top: 110px;">「侧面」轻触拍照</h2>
									<br>
									<h2 class="one" style="margin-top: 100px;">「后侧」轻触拍照</h2>
								</div>
								<div class="col-sm-9">
									<canvas id="A" width="500" height="300" style="background-image:url({{asset('weui/images/photo.jpg')}});float: right;"></canvas>
								
									<canvas id="B" width="500" height="300" style="background-image:url({{asset('weui/images/photo.jpg')}});float: right;"></canvas>
									
									<canvas id="C" width="500" height="300" style="background-image:url({{asset('weui/images/photo.jpg')}});float: right;"></canvas>
								</div>
							
								
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
			
	</div>

@endsection
@section('js_code')
    <script type="text/javascript">
        var BASE_URL = 'http://cdn.staticfile.org/webuploader/0.1.0/';
        var webuploader_post = '{{route('index.order.uploadImage')}}?order_id={{$list->id}}';
    </script>
    <script src="{{asset('backend/plugins/webuploader/webuploader.min.js')}}"></script>
    <script src="{{asset('backend/plugins/webuploader/webuploader-demo.min.js')}}"></script>
	<script>
	    //访问用户媒体设备的兼容方法
        function getUserMedia(constraints, success, error) {
            if (navigator.mediaDevices.getUserMedia) {
                //最新的标准API
                navigator.mediaDevices.getUserMedia(constraints).then(success).catch(error);
            } else if (navigator.webkitGetUserMedia) {
                //webkit核心浏览器
                navigator.webkitGetUserMedia(constraints, success, error)
            } else if (navigator.mozGetUserMedia) {
                //firfox浏览器
                navigator.mozGetUserMedia(constraints, success, error);
            } else if (navigator.getUserMedia) {
                //旧版API
                navigator.getUserMedia(constraints, success, error);
            }
        }

        let video = document.getElementById('video');
        //let canvas = document.getElementById('canvas');
        //let context = canvas.getContext('2d');

        let C1 = document.getElementById('A');
        let C2 = document.getElementById('B');
        let C3 = document.getElementById('C');

        let context1 = C1.getContext('2d');
        let context2 = C2.getContext('2d');
        let context3 = C3.getContext('2d');

		var hasImageA = false;
		var hasImageB = false;
		var hasImageC = false;


        function success(stream) {
            //兼容webkit核心浏览器
            let CompatibleURL = window.URL || window.webkitURL;
            //将视频流设置为video元素的源
            console.log(stream);

            //video.src = CompatibleURL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        }

        function error(error) {
            console.log(`访问用户媒体设备失败${error.name}, ${error.message}`);
        }


        if (navigator.mediaDevices.getUserMedia || navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia) {
            //调用用户媒体设备, 访问摄像头
            getUserMedia({ video: { width: 1920, height: 1080 } }, success, error);
        } else {
            alert('不支持访问用户媒体');
        }

        //document.getElementById('capture').addEventListener('click', function () {
        //    context.drawImage(video, 0, 0, 320, 180);
        //})
        
        document.getElementById('A').addEventListener('click', function () {        
			if(hasImageA) {
				//询问框
				parent.layer.confirm('已有[正面]照片，是否删除之前照片？', {
					btn: ['重拍','取消'], //按钮
					shade: true //不显示遮罩
				}, function(){
					parent.layer.closeAll();
					context1.clearRect(0,0,C1.width,C1.height);  
					hasImageA = false;

				}, function(){
					
				});
			}
			else {
				context1.drawImage(video, 0, 0, 500, 300);
				hasImageA = true;
         	}
        })
        document.getElementById('B').addEventListener('click', function () {
			if(hasImageB) {
				//询问框
				parent.layer.confirm('已有[侧面]照片，是否删除之前照片？', {
					btn: ['重拍','取消'], //按钮
					shade: true //不显示遮罩
				}, function(){
					parent.layer.closeAll();
					context2.clearRect(0,0,C2.width,C2.height);  
					hasImageB = false;

				}, function(){
					
				});
			}
			else {
				context2.drawImage(video, 0, 0, 500, 300);
				hasImageB = true;
         	}
          
        })
        document.getElementById('C').addEventListener('click', function () {
			if(hasImageC) {
				//询问框
				parent.layer.confirm('已有[后侧]照片，是否删除之前照片？', {
					btn: ['重拍','取消'], //按钮
					shade: true //不显示遮罩
				}, function(){
					parent.layer.closeAll();
					context3.clearRect(0,0,C3.width,C3.height);  
					hasImageC = false;

				}, function(){
					
				});
			}
			else {
				context3.drawImage(video, 0, 0, 500, 300);
				hasImageC = true;
         	}
         
        })


        //将Canvas图片数据上传到服务器
        /*
        * 图片格式说明，存储图片大小 png > jpg> jpeg
        */
        $('#ctlBtn1').on({
            click: function () {

				if(!hasImageA){
					alert("请上传正面照");
					return;
				}
				else if(!hasImageB){
					alert("请上传测面照");
					return;

				}
				else if(!hasImageC){
					alert("请上传后侧照");
					return;
				}
				else {
					//alert("都上传完了");
					//1.获取canvas中的图片数据
					//正面
					var data = C1.toDataURL('image/jpeg');
					data = data.split(',')[1];
					//数据格式转换
					data = window.atob(data);
					var ia = new Uint8Array(data.length);
					for (var i = 0; i < data.length; i++) {
						ia[i] = data.charCodeAt(i);
					}
					var blob = new Blob([ia], { type: 'image/jpeg' });

					//侧面
					var data1 = C2.toDataURL('image/jpeg');
					data1 = data1.split(',')[1];
					//数据格式转换
					data1 = window.atob(data1);
					var ia1 = new Uint8Array(data1.length);
					for (var i = 0; i < data1.length; i++) {
						ia1[i] = data1.charCodeAt(i);
					}
					var blob1 = new Blob([ia1], { type: 'image/jpeg' });

					//背面
					var data2 = C3.toDataURL('image/jpeg');
					data2 = data2.split(',')[1];
					//数据格式转换
					data2 = window.atob(data2);
					var ia2 = new Uint8Array(data2.length);
					for (var i = 0; i < data2.length; i++) {
						ia2[i] = data2.charCodeAt(i);
					}
					var blob2 = new Blob([ia2], { type: 'image/jpeg' });


					//2.提交到服务器
					var fd = new FormData();
					fd.append('file[]', blob); 
					fd.append('file[]', blob1);
					fd.append('file[]', blob2);
					console.log(fd);

					//提交到服务器
					var xhr = new XMLHttpRequest();
					xhr.open('post', webuploader_post, true);
					xhr.onreadystatechange = function () {
						if (xhr.readyState == 4 && xhr.status == 200) {
							var data = eval('(' + xhr.responseText + ')');
							if (data.msg=="success") {
								//上传成功
								//var imgName = data.msg;
								//alert(imgName);
								//alert("上传成功");
								parent.layer.msg('上传成功');
								//window.location.href = "{{route('index.order.index')}}";
								setTimeout('location.href="{{route('index.order.index')}}"', 1500);  

							} else {
								//上传失败
								alert(data.msg);
							}
						} else {
							//alert(xhr.readyState);
						}
					}
					xhr.send(fd);
				}




            }
        });
	</script>
    @endsection
