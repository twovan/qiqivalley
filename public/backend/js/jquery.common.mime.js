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
    // 选择按钮
    var checkboxClass = 'icheckbox_flat-blue';
    var radioClass = 'iradio_flat-blue';
    $('input.icheck[type=checkbox],input.icheck[type=radio]').iCheck({
        checkboxClass: checkboxClass,
        radioClass: radioClass
    });
    $("span.icon input:checkbox, th input:checkbox").on('ifChecked || ifUnchecked',function() {
        var checkedStatus = this.checked;
        var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');
        checkbox.each(function() {
            this.checked = checkedStatus;
            if (checkedStatus == this.checked) {
                $(this).closest('.' + checkboxClass).removeClass('checked');
            }
            if (this.checked) {
                $(this).closest('.' + checkboxClass).addClass('checked');
            }
        });
    });

    // 表格
    $(".table").footable();

    // 表单验证
    $.validator.setDefaults({
        highlight: function (e) {
            $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
        }, success: function (e) {
            e.closest(".form-group").removeClass("has-error").addClass("has-success")
        }, errorElement: "span", errorPlacement: function (e, r) {
            e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent())
        }, errorClass: "help-block m-b-none", validClass: "help-block m-b-none"
    });

    // 状态选择
    $('#form-status').chosen({
        width: '100%',
        disable_search_threshold: 2
    });

    // 更新 chosen
    // $('#form-parent_id').val(2).trigger('chosen:updated');

    // ajax 添加csrf
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

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
        swal('未选择','请勾选需要操作的信息');
        return false;
    }else {
        return true;
    }
};

/**
 * ajax提交请求
 * @param type
 * @param url
 * @param data
 * @param location
 */
var subActionAjaxForMime = function (type, url, data, location) {
    $.ajax({
        type: type,
        url: url,
        data: data,
        success: function(res){
            if(res.code == 200){
                //swal({
                //    title: "成功",
                //    type: "success",
                //    confirmButtonColor: "#1ab394",
                //    confirmButtonText: "确定",
                //    closeOnConfirm: false
                //}, function () {
                //    window.location.href = location;
                //});
                window.location.href = location;
            }else {
                swal({
                    title: "失败",
                    text: res.msg,
                    type: "warning",
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: "确定",
                    closeOnConfirm: false
                });
            }
        },
        error:function (res) {
            swal({
                title: "失败",
                text: res.responseText,
                type: "warning",
                confirmButtonColor: "#1ab394",
                confirmButtonText: "确定",
                closeOnConfirm: false
            });
        }
    });
};

/**
 *  获取dom列表的值
 * @param dataList
 * @returns {Array}
 */
var getDataListForMime = function(dataList) {
    var list = [], j = 0;
    for(var i = 0; i < dataList.length; i++){
        var child = dataList[i];
        if(('radio' == child.type || 'checkbox' == child.type)){
            if(true == child.checked){
                list[j] = $(child).val();
                j++;
            }
        }else {
            list[i] = $(child).val();
        }
    }
    return list;
};

/**
 * 重置文件上传进度条状态
 * @param inputId
 */
var uploadDataReset = function (inputId) {
    $('#progress-' + inputId + ' .progress-bar').width(0).find('span').text('');
};

/**
 * 启用操作
 * @param check
 * @param stats_url
 * @param index_url
 */
var enableDataMultiple = function (check, stats_url, index_url) {
    swal({
        title: "您确定要启用选中的信息吗",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonColor: "#23c6c8",
        confirmButtonText: "确定",
        closeOnConfirm: false
    }, function () {
        var data = {};
        data.selection = getDataListForMime(check);
        data.status = 1;
        console.log(data);
        subActionAjaxForMime('post', stats_url, data, index_url);
    });
};

/**
 * 禁用操作
 * @param check
 * @param stats_url
 * @param index_url
 */
var disableDataMultiple = function (check, stats_url, index_url) {
    swal({
        title: "您确定要禁用选中的信息吗",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "确定",
        closeOnConfirm: false
    }, function () {
        var data = {};
        data.selection = getDataListForMime(check);
        data.status = 0;
        console.log(data);
        subActionAjaxForMime('post', stats_url, data, index_url);
    });
};

/**
 * 禁用操作
 * @param check
 * @param delete_url
 * @param index_url
 */
var deleteDataMultiple = function (check, delete_url, index_url) {
    swal({
        title: "此操作不可恢复，您确定要删除选中的信息吗",
        type: "error",
        showCancelButton: true,
        cancelButtonText: '取消',
        confirmButtonColor: "#f27474",
        confirmButtonText: "确定",
        closeOnConfirm: false
    }, function () {
        var data = {};
        data.selection = getDataListForMime(check);
        console.log(data);
        subActionAjaxForMime('post', delete_url, data, index_url);
    });
};

/**
 * ajax根据appId变化获取扩展列表
 * @param url
 * @param data
 * @param element
 * @param type
 */
var changeListDataByAjaxForMime = function (url, data, element, type, defaultVal) {
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        success: function(res){
            if(res.code == 200){
                console.log(res.data);
                if('optionHtml' == type){
                    selectOptionHtmlForMime(res.data, element, defaultVal);
                }else if('optionPrepend' == type){
                    selectOptionPrependForMime(res.data, element);
                }else if('formHtml' == type){
                    formHtmlForMime(res.data, element);
                }
            }
        }
    });
};

/**
 * select 内容遍历替换
 * @param list
 * @param element
 */
var selectOptionHtmlForMime = function (list, element, defaultVal) {

    var html = '<option value="">请选择</option>';
    for(var i in list){
        html += '<option value="' + i + '"' ;
        if(defaultVal == i){
            html += 'selected ';
        }
        html +=  '>' + list[i] + '</option>';
    }
    $(element).html(html);
};

/**
 * select 内容遍历追加
 * @param list
 * @param element
 */
var selectOptionPrependForMime = function (list, element) {
    var html = '';
    for(var i in list){
        html += '<option value="' + i + '">' + list[i] + '</option>';
    }
    $(element).prepend(html);
};

/**
 * form html 内容遍历替换
 * @param list
 * @param element
 */
var formHtmlForMime = function (list, element) {
    var html = '';
    for(var i in list){
        html += '<div class="form-group">';
        html += '    <label class="col-sm-3 col-md-3 col-lg-2 control-label">' + list[i] + '</label>';
        html += '    <div class="col-sm-9 col-md-9 col-lg-10">';
        html += '        <input type="text" class="form-control input-sm" name="' + i + '" id="form-' + i + '">';
        html += '    </div>';
        html += '</div>';
    }
    $(element).html(html);
};

/**
 * 有表单验证的ajax提交
 * @param formId
 * @param rules
 * @param form_url
 * @param index_url
 */
var subActionAjaxValidateForMime = function (formId, rules, form_url, index_url) {
    // 验证手机号
    jQuery.validator.addMethod("phone", function(value, element) {
        var tel = /^1[35789]\d{9}$/;
        return this.optional(element) || (tel.test(value));
    }, "请填写正确的11位手机号");
    $(formId).validate({
        rules:rules,
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler:function(form) {
            var data = $(formId).serialize();
            console.log(data);
            subActionAjaxForMime('post', form_url, data, index_url);
        } //这是关键的语句，配置这个参数后表单不会自动提交，验证通过之后会去调用的方法
    });
};
