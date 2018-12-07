@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <form method="post" id="form-add_class">
                <div class="weui-cells weui-cells_form margin0">
                    <div class="weui-panel__hd weui-media-box_text">
                        <h4 class="weui-media-box__title fontc-black">会员信息</h4>
                        <p class="weui-media-box__desc">您的会员资料</p>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><label class="weui-label">家长姓名</label></div>
                        <div class="weui-cell__bd">
                            <p id="form-phone">{{$list->name}}</p>
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                        <div class="weui-cell__bd">
                            <p id="form-tel">{{$list->phone}}</p>
                        </div>
                    </div>
                    <div id="kids">
                        <?php $kids = $list->kids; ?>
                        @foreach($kids as $k=>$v)
                        <div id="kidinfo{{$k+1}}" class="weui-cells__title">
                            孩子信息
                        </div>
                        <div id="kid1">
                            <div class="weui-cell">
                                <div class="weui-cell__hd"><label class="weui-label">孩子姓名</label></div>
                                <div class="weui-cell__bd">
                                    <p>{{$v->name}}</p>
                                </div>
                            </div>
                            <div class="weui-cell">
                                <div class="weui-cell__hd">
                                    <label for="" class="weui-label">孩子性别</label>
                                </div>
                                <div class="weui-cell__bd">
                                    <p> @if($v->sex == 0) 男 @else 女 @endif &nbsp;</p>
                                </div>
                            </div>
                            <div class="weui-cell">
                                <div class="weui-cell__hd">
                                    <label for="" class="weui-label">孩子生日</label>
                                </div>
                                <div class="weui-cell__bd">
                                    <p>{{$v->DOB}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="weui-btn-area page__bd_footer">
                    <a class="weui-btn weui-btn_primary" href="{{url('wechat/user/edit_memberinfo')}}" id="btn_modify">编    辑</a>
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


        var kidsnum = 1;//小孩自增ID(个数)

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
            if (kidsnum == 5) {
                alert("最多添加"+kidsnum+"个孩子!");
            }
            else {
                //alert(kidsnum);
                kidsnum = ++kidsnum;
                var html = "            <div id=\"kidinfo" + kidsnum + "\" class=\"weui-cells__title\">孩子信息\n" +
                    "                            <span class=\"pull-right fa fa-minus-circle\" onclick=\"delKids(" + kidsnum + ")\"></span>\n" +
                    "                        </div>\n" +
                    "                        <div id=\"kid" + kidsnum + "\">\n" +
                    "                            <div class=\"weui-cell\">\n" +
                    "                                <div class=\"weui-cell__hd\"><label class=\"weui-label\">孩子姓名</label></div>\n" +
                    "                                <div class=\"weui-cell__bd\">\n" +
                    "                                    <input class=\"weui-input\" type=\"tel\" name=\"phone\" id=\"form-kidname" + kidsnum + "\"\n" +
                    "                                           placeholder=\"请输入孩子姓名\">\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                            <div class=\"weui-cell weui-cell_select weui-cell_select-after\">\n" +
                    "                                <div class=\"weui-cell__hd\">\n" +
                    "                                    <label for=\"\" class=\"weui-label\">孩子性别</label>\n" +
                    "                                </div>\n" +
                    "                                <div class=\"weui-cell__bd\">\n" +
                    "                                    <select class=\"weui-select\" name=\"sex" + kidsnum + "\">\n" +
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
                    "                                    <input id=\"BOD" + kidsnum + "\" class=\"weui-input\" type=\"date\" value=\"\">\n" +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                        </div>";
                $("#kids").append(html);
            }
            ;
        }

    </script>
@endsection
