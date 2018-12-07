@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <form method="post" id="form-add_class">
            <div class="weui-cells weui-cells_form margin0">
                <div class="weui-panel__hd weui-media-box_text">
                    <h4 class="weui-media-box__title fontc-black">更换手机号</h4>
                    <p class="weui-media-box__desc">请填写您的新手机号码</p>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="tel" name="phone" id="form-phone" placeholder="请输入手机号" tips="手机号格式不正确">
                    </div>
                </div>
                <div class="weui-cell weui-cell_vcode">
                    <div class="weui-cell__hd">
                        <label class="weui-label">验证码</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="number" name="vcode" id="form-vcode" placeholder="请输入验证码">
                    </div>
                    <div class="weui-cell__ft">
                        <a href="javascript:get_vcode();" class="weui-vcode-btn  fz13" id="get_vcode">获取验证码</a>
                    </div>
                </div>
            </div>

            <div class="weui-btn-area page__bd_footer">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="btn_save">确定</a>
            </div>
            </form>
        </div>

        @include('weChat.layout.copyright')
    </div>
@endsection
@section('js')
    <script>
        //获取url中的参数
        function getUrlParam(name) {
         var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
         var r = window.location.search.substr(1).match(reg); //匹配目标参数
         if (r != null) return unescape(r[2]); return null; //返回参数值
        }


        function get_vcode() {
            timer($('#get_vcode'),40);
            var form_url = '{{url('wechat/getVCode')}}';
            var phone = $('#form-phone').val();
            var data = {
                'phone': phone
            };
            subActionAjaxForMime(form_url, data);
        }
        $(function () {

            var pattern = {
//                REG_PHONE:/^1[3456789]\d{9}$/,
//                REG_VCODE:/^.{4}$/
            };
            weui.form.checkIfBlur('#form-add_class', {
                regexp: pattern
            });
            // 表单提交
            var btn_save = $('#btn_save');
            btn_save.click(function () {
                var sid = getUrlParam('sid');
                var vip = getUrlParam('vip');
                //alert(sid);
                weui.form.validate('#form-add_class', function (error) {
                    if (!error) {
                        var form_url = '{{url('wechat/user/update_phone')}}';
                        var jump_url = '{{url('wechat/user')}}';
                        //如果是通过点击服务自动跳转的,那么完成绑定后再跳回去.2018.9.7
                        if (sid != undefined) {
                            jump_url='http://qqg.twovan.cn/wechat/service/'+sid;
                        }
                        if(vip != undefined){
                            jump_url='http://qqg.twovan.cn/wechat/user/vipCard/';
                        }

                        var data = $('#form-add_class').serialize();
                        subActionAjaxForMime(form_url, data, jump_url);
                    }
                }, {
                    regexp: pattern
                });
            });
        });
    </script>
@endsection
