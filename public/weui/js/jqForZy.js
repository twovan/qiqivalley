/**
 * 基于jQuery的方法
 * author zhaiyu
 * startDate 20160511
 * updateDate 20160511
 */

console.log('jq-common-mime');

/**
 * 公共js脚本
 */
$(function(){

    // ajax 添加csrf
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

/**
 * ajax提交请求
 * @param url
 * @param data
 * @param jump_url
 */
var subActionAjaxForMime = function (url, data, jump_url) {
    var loading = weui.loading('提交中...');
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        success: function(res){
            if(res.code == 200){
                loading.hide();
                weui.toast('成功');
                if(jump_url){
                    setTimeout(function () {
                        window.location.href = jump_url;
                    },500);
                }
            }else {
                loading.hide();
                weui.alert(res.msg);
            }
        },
        error:function () {
            loading.hide();
            weui.alert('网络中断异常!请刷新后再试');
        }
    });
};

/**
 * 判断多选框是否有勾选，有勾选返回true，没有则弹窗提示并返回false
 * @param check array
 * @returns {boolean}
 */
var verifyCheckedForMime = function (check) {
    var checked = 0;
    for(var i =0; i < check.length; i++){
        if(check[i].checked == true){
            checked++;
        }
    }
    if(0 == checked){
        return false;
    }else {
        return true;
    }
};

/**
 * 获取验证码倒计时
 * @param that
 * @param t
 */
var timer = function (that,t) {
    var s = setInterval(function () {
        // console.log(that);
        that.html(t + '秒后重试');
        that.attr('href', 'javascript:;');
        that.css('color', '#999999');
        if (t <= 0) {
            clearTimeout(s);
            that.html('获取验证码');
            that.attr('href', 'javascript:get_vcode();');
            that.css('color', '#3CC51F');
        }
        t--;
    }, 1000);
};