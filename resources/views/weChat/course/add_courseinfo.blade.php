@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <form method="post" id="form-add_class"  action="{{url('wechat/course/savecourseinfo')}}" name="savecourse">
                <div class="weui-cells weui-cells_form margin0">
                    <div class="weui-panel__hd weui-media-box_text">
                        <h4 class="weui-media-box__title fontc-black">增加课程记录</h4>
                        <p class="weui-media-box__desc">请填写您的会员资料</p>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd">
                            <label class="weui-label">课程名称</label>
                        </div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="text" name="courses_name" id="form-courses_name" placeholder="请输入课程名称">
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd">
                            <label for="" class="weui-label">课程时间</label>
                        </div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="datetime-local" name="courses_ts" id="form-courses_ts" placeholder="">
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd">
                            <label for="" class="weui-label">上课人数</label>
                        </div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="text" name="courses_num" id="form-courses_num" value=""
                                   placeholder="">
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><label class="weui-label">上课老师</label></div>
                        <div class="weui-cell__bd">
                            <p id="form-phone">{{$list->name}}</p>
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="tel" name="phone" id="form-phone" placeholder="请输入手机号"
                                   tips="手机号格式不正确" value="{{$list->phone}}" readonly>
                        </div>
                    </div>
                    <div class="weui-cell weui-cell_switch">
                        <div class="weui-cell__bd">是否使用耗材</div>
                        <div class="weui-cell__ft">
                            <input id="isMaterial" class="weui-switch" type="checkbox" onclick="Material()">
                        </div>
                    </div>
                    <div id="Materials" style="display: none">
                        <div class="weui-cells__title">
                            耗材信息列表
                            <?php
                            $options = "";
                            if (collect($material)->isNotEmpty()) {
                                foreach ($material as $items) {
                                    $options .= "<option value='" . $items->id . "'>" . $items->material_name . "</option>";
                                }
                            }
                            ?>
                        </div>
                        <div id="Material1">
                            <div class="weui-cell weui-cell_vcode">
                                <div class="weui-cell__hd weui-cell_select">
                                    @if(empty($options))
                                        暂无耗材记录，请在后台添加!
                                    @else
                                        <select class="weui-select" name="material[0][material_id]">

                                            {!! $options !!}

                                        </select>
                                    @endif
                                </div>
                                <div class="weui-cell__bd">
                                    <p>X</p>
                                </div>
                                <div class="weui-cell__bd">
                                    <input id="mnum1" class="weui-input" type="number" pattern="[0-9]*" placeholder="数量"
                                           name="material[0][num]" value="1">
                                </div>
                                <div class="weui-cell__ft">

                                    <div class="weui-vcode-btn" onclick="addMaterial()"><span
                                                class="fa fa-plus-circle"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="weui-btn-area page__bd_footer">
                    <a class="weui-btn weui-btn_primary"href="javascript:void(0)" id="btn_save" onClick="document.forms['savecourse'].submit();">保 存</a>
                </div>
                {{ csrf_field() }}
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
            if (r != null) return unescape(r[2]);
            return null; //返回参数值
        }


        //启用耗材按钮事件
        function Material() {
            if ($('#isMaterial').prop('checked')) {
                //do something
                // alert("open");
                $('#Materials').show();

            }
            else {
                // alert("close");
                $('#Materials').hide();
            }
        }


        var mnum = 1;//耗材自增ID(个数)
        var optionlist = " {!! $options !!}";
        console.log(optionlist);

        //删除耗材信息
        function delMaterial(mid) {
            // alert("del");
            $("#Material" + mid).remove();
            if (mnum != 1) {
                mnum = --mnum;
            }
        }

        //动态添加耗材信息
        function addMaterial() {
            if (mnum == 10) {
                alert("最多添加" + mnum + "个耗材!");
            }
            else {
                //alert(kidsnum);
                console.log(optionlist + '123');
                mnum = ++mnum;


                var html = "                        <div id=\"Material" + mnum + "\">\n" +
                    "                            <div class=\"weui-cell weui-cell_vcode\">\n" +
                    "                                <div class=\"weui-cell__hd weui-cell_select\">\n" +
                    "                                    <select class=\"weui-select\" name=\"material["+mnum+"][material_id]\">\n" +
                    optionlist + "\n" +
                    "                                    </select>\n" +
                    "                                </div>\n" +
                    "                                <div class=\"weui-cell__bd\">\n" +
                    "                                    <p>X</p>\n" +
                    "                                </div>\n" +
                    "                                <div class=\"weui-cell__bd\">\n" +
                    "                                    <input id=\"mnum" + mnum + "\" class=\"weui-input\" type=\"number\"  pattern=\"[0-9]*\" placeholder=\"数量\"\n" +
                    "                                           value=\"1\" name=\"material["+mnum+"][num]\">\n" +
                    "                                </div>\n" +
                    "                                <div class=\"weui-cell__ft\">\n" +
                    "                                    <div class=\"weui-vcode-btn\" style='color: red;' onclick='delMaterial(" + mnum + ")'><span class=\"fa fa-minus-circle\"></span></div>\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                        </div>";
                $("#Materials").append(html);
            }
            ;
        }

    </script>
@endsection
