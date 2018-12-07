@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <form method="post" action="{{url('wechat/user/save_memberinfo')}}" name="editmember" id="form-add_class">
                <div class="weui-cells weui-cells_form margin0">
                    <div class="weui-panel__hd weui-media-box_text">
                        <h4 class="weui-media-box__title fontc-black">更改会员信息</h4>
                        <p class="weui-media-box__desc">请填写您的会员资料</p>

                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><label class="weui-label">家长姓名</label></div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="text" name="name" id="form-name" placeholder="请输入家长姓名" value="{{$list->name}}" >
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="tel" name="phone" id="form-phone" placeholder="请输入手机号"
                                   tips="手机号格式不正确" value="{{$list->phone}}" readonly>
                        </div>
                    </div>
                    <div id="kids">
                        <div id="kidinfo1" class="weui-cells__title">添加孩子信息
                            <span class="pull-right fa fa-plus" onclick="addKids()"></span>
                        </div>
                        <?php
                            $kids = $list->kids;
                            $key_count = collect($list->kids)->isNotEmpty()?collect($list->kids)->count():0;
                        ?>
                        @if($key_count>0)
                        @foreach($kids as $k=>$v)
                        <div id="kid{{$k+1}}">
                            <div class="weui-cell">
                                <div class="weui-cell__hd"><label class="weui-label">孩子姓名</label></div>
                                <div class="weui-cell__bd">
                                    <input class="weui-input" type="text" name="kids['{{$k}}'][name]" id="form-kidname{{$k+1}}"
                                           placeholder="请输入孩子姓名" value="{{$v->name}}">
                                </div>
                            </div>
                            <div class="weui-cell weui-cell_select weui-cell_select-after">
                                <div class="weui-cell__hd">
                                    <label for="" class="weui-label">孩子性别</label>
                                </div>
                                <div class="weui-cell__bd">
                                    <select class="weui-select" name="kids['{{$k}}'][sex]">
                                        <option value="0"  @if ($v->sex==0) selected @endif>男</option>
                                        <option value="1" @if ($v->sex==1) selected @endif>女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="weui-cell">
                                <div class="weui-cell__hd">
                                    <label for="" class="weui-label">孩子生日</label>
                                </div>
                                <div class="weui-cell__bd">
                                    <input id="BOD{{$k+1}}" class="weui-input" name="kids['{{$k}}'][dob]" type="date" value="{{$v->DOB}}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="weui-btn-area page__bd_footer">
                    <a class="weui-btn weui-btn_primary" href="javascript:void(0)" id="btn_save" onClick="document.forms['editmember'].submit();">保    存</a>
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
            if (r != null) return unescape(r[2]);
            return null; //返回参数值
        }


        var start = "{{$key_count}}";
        start = parseInt(start);
        var kidsnum = 0;//小孩自增ID(个数)

        //删除小孩信息
        function delKids(kidsid) {
            // alert("del");
            if (confirm("确定删除该条信息?")) {
                $("#kidinfo" + kidsid).remove();
                $("#kid" + kidsid).remove();
                if (kidsnum != 1) {
                    kidsnum = --kidsnum;
                }

            }
        }

        //动态添加小孩信息
        function addKids() {
            var endnum = start>0?(kidsnum+start):kidsnum-1;
            if (endnum == 5) {
                alert("最多添加"+endnum+"个孩子!");
            }
            else {
                //alert(kidsnum);
                kidsnum = ++kidsnum;
                allkids = (kidsnum+start)
                var html = "            <div id=\"kidinfo" + allkids + "\" class=\"weui-cells__title\">孩子信息\n" +
                    "                            <span class=\"pull-right fa fa-minus-circle\" onclick=\"delKids(" + allkids + ")\"></span>\n" +
                    "                        </div>\n" +
                    "                        <div id=\"kid" + allkids + "\">\n" +
                    "                            <div class=\"weui-cell\">\n" +
                    "                                <div class=\"weui-cell__hd\"><label class=\"weui-label\">孩子姓名</label></div>\n" +
                    "                                <div class=\"weui-cell__bd\">\n" +
                    "                                    <input class=\"weui-input\" type=\"text\" name=\"kids["+allkids+"][name]\" id=\"form-kidname" + allkids + "\"\n" +
                    "                                           placeholder=\"请输入孩子姓名\">\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                            <div class=\"weui-cell weui-cell_select weui-cell_select-after\">\n" +
                    "                                <div class=\"weui-cell__hd\">\n" +
                    "                                    <label for=\"\" class=\"weui-label\">孩子性别</label>\n" +
                    "                                </div>\n" +
                    "                                <div class=\"weui-cell__bd\">\n" +
                    "                                    <select class=\"weui-select\" name=\"kids["+allkids+"][sex]\">\n" +
                    "                                        <option value=\"1\">男</option>\n" +
                    "                                        <option value=\"0\">女</option>\n" +
                    "                                    </select>\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                            <div class=\"weui-cell\">\n" +
                    "                                <div class=\"weui-cell__hd\">\n" +
                    "                                    <label for=\"\" class=\"weui-label\">孩子生日</label>\n" +
                    "                                </div>\n" +
                    "                                <div class=\"weui-cell__bd\">\n" +
                    "                                    <input id=\"BOD" + allkids + "\" class=\"weui-input\" type=\"date\" name=\"kids["+allkids+"][dob]\" value=\"\">\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                        </div>";
                $("#kids").append(html);
            }
            ;
        }

    </script>
@endsection
