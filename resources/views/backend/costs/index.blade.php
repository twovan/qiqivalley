@extends('backend.layout.app')

@section('content')
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title no-borders">
                    <form role="form" class="form-inline" method="post" action="{{route('backend.costs.search')}}">
                        {{ csrf_field()}}
                        <div class="form-group form-group-sm">
                            <label>手机号码查询：</label>
                            <input type="text" name="b_tel" value="" class="form-control" placeholder="请输入手机号码进行查询">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">查询</button>
                        丨
                        <div class="form-group form-group-sm">
                            <label>用户姓名查询：</label>
                            <input type="text" name="b_name" value="" class="form-control" placeholder="请输入姓名进行查询">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">查询</button>
                    </form>
                </div>


                <div class="ibox-title clearfix">
                    <h5>
                        <small>消费信息列表</small>
                    </h5>
                    <div class="pull-right">
                        {{--<button class="btn btn-info btn-xs" data-form="add-model" data-toggle="modal" data-target="#formModal">添加</button>--}}
                    </div>
                </div>
                <div class="ibox-content">

                    @if($flag ==0)

                        <table class="table table-stripped toggle-arrow-tiny" data-sort="false">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户姓名</th>
                                <th>手机号</th>
                                <th>消费前金额</th>
                                <th>消费前门票</th>
                                <th>金额变化数</th>
                                <th>门票变化数</th>
                                <th>消费店铺</th>
                                <th>消费时间</th>
                                <th>操作人</th>
                                <th>操作时间</th>
                                <th data-hide="all">消费明细</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(collect($default_lists)->isEmpty())
                                <tr>
                                    <td colspan="12">暂无记录</td>
                                </tr>
                            @else
                                @foreach($default_lists as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->user->name}}</td>
                                        <td>{{$list->user->phone}}</td>
                                        <td>{{$list->last_balance}}</td>
                                        <td>{{$list->last_ticket}}</td>
                                        <td style="color: red">- ¥{{$list->amount}}</td>
                                        <td style="color: red">- {{$list->ticket_num}}张</td>
                                        <td>{{$list->store->name}}</td>
                                        <td>{{$list->cost_ts}}</td>
                                        <td>{{$list->admin->name}}</td>
                                        <td>{{$list->created_at}}</td>
                                        <td>
                                            <?php
                                            $detail = $list->details;
                                            if (collect($detail)->isEmpty()) {
                                                echo "暂无记录";
                                            } else {

                                                //查询项目
                                                foreach ($detail as $items) {
                                                    if ($items->cost_type == 0) {
                                                        $service_id= $items->service_id;
                                                        //dd($service_arr);
                                                        $server_info = $service_arr[$service_id];

                                                        echo $server_info['name'] . 'x' . $items->server_num . '   <span style="color: red"> ¥' . $server_info['price'] . '</span>   门票 <span style="color: red">' . $items->ticket_num . ' </span>张<br/>';
                                                    } else {
                                                        echo '杂项: ' . $sundry['sundry_name'] . ' <span style="color: red">¥' . $sundry['sundry_price'] . '</span>   门票 <span style="color: red">' . $sundry['ticket_num'] . ' </span>张<br/>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-xs" data-form="edit-model"
                                                    data-toggle="modal"
                                                    data-target="#formModal"
                                                    data-user_id="{{$list->user_id}}"
                                                    data-name="{{$list->user->name}}"
                                                    data-phone="{{$list->user->phone}}"
                                                    data-balance="{{$list->user->balance}}"
                                                    data-ticket="{{$list->user->ticket}}"
                                            >消费
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>


                    @else
                        @if(collect($list)->isNotEmpty())
                            @if(empty($list['cost']))

                                <table class="table table-stripped toggle-arrow-tiny" data-sort="false">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>用户姓名</th>
                                        <th>手机号</th>
                                        <th>昵称</th>
                                        <th>余额</th>
                                        <th>剩余门票</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$list['user']['id']}}</td>
                                        <td>{{$list['user']['name']}}</td>
                                        <td>{{$list['user']['phone']}}</td>
                                        <td>{{$list['user']['wx_name']}}</td>
                                        <td>¥{{$list['user']['balance']}}</td>
                                        <td>{{$list['user']['ticket']}}张</td>
                                        <td>
                                            <button class="btn btn-danger btn-xs" data-form="edit-model"
                                                    data-toggle="modal"
                                                    data-target="#formModal"
                                                    data-user_id="{{$list['user']['id']}}"
                                                    data-name="{{$list['user']['name']}}"
                                                    data-phone="{{$list['user']['phone']}}"
                                                    data-balance="{{$list['user']['balance']}}"
                                                    data-ticket="{{$list['user']['ticket']}}"
                                            >消费
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            @else

                                <table class="table table-stripped toggle-arrow-tiny" data-sort="false">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>用户姓名</th>
                                        <th>手机号</th>
                                        <th>消费前金额</th>
                                        <th>消费前门票</th>
                                        <th>金额变化数</th>
                                        <th>门票变化数</th>
                                        <th>消费时间</th>
                                        <th>操作人</th>
                                        <th>操作时间</th>
                                        <th data-hide="all">消费明细</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>

                                        <td>{{$list['cost'] ->id}}</td>
                                        <td>{{$list['cost']->user->name }}</td>
                                        <td>{{$list['cost'] ->user->phone}}</td>
                                        <td>{{$list['cost'] ->last_balance}}</td>
                                        <td>{{$list['cost'] ->last_ticket}}</td>
                                        <td style="color: red">- ¥{{$list['cost'] ->amount}}</td>
                                        <td style="color: red">- {{$list['cost'] ->ticket_num}}张</td>
                                        <td>{{$list['cost'] ->cost_ts}}</td>
                                        <td>{{$list['cost'] ->admin->name}}</td>
                                        <td>{{$list['cost'] ->created_at}}</td>
                                        <td>
                                            <?php
                                            $cost_detail = $list['cost']->details;
                                            if (collect($cost_detail)->isEmpty()) {
                                                echo "暂无记录";
                                            } else {

                                                //查询项目
                                                $server_cost_list = collect($cost_detail)->where('cost_type', 0)->get();
                                                if (collect($server_cost_list)->isEmpty()) {
                                                    foreach ($server_cost_list as $value) {
                                                        $server_id = $value->server_id;
                                                        $server_info = $server_arr[$server_id];
                                                        echo $server_info['name'] . 'x' . $value->server_num . '   <span style="color: red"> ¥' . $server_info['price'] . '</span>   门票 <span style="color: red">' . $value->ticket_num . ' </span>张';
                                                    }
                                                }

                                                //查询杂项
                                                $sundry = collect($cost_detail)->where('cost_type', 1)->first();
                                                if (!empty($sundry)) {
                                                    echo '杂项: ' . $sundry['sundry_name'] . ' <span style="color: red">¥' . $sundry['sundry_price'] . '</span>   门票 <span style="color: red">' . $sundry['ticket_num'] . ' </span>张';
                                                }

                                            }

                                            ?>

                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-xs" data-form="edit-model"
                                                    data-toggle="modal"
                                                    data-target="#formModal"
                                                    data-user_id="{{$list->user_id}}"
                                                    data-name="{{$list->user->name}}"
                                                    data-phone="{{$list->user->phone}}"
                                                    data-balance="{{$list->user->balance}}"
                                                    data-ticket="{{$list->user->ticket}}"
                                            >消费
                                            </button>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>

                            @endif

                        @else
                            <table class="table table-stripped toggle-arrow-tiny" data-sort="false">
                                <tr>
                                    <td colspan="12">暂无记录</td>
                                </tr>
                            </table>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class=" modal inmodal fade
                                    " id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加{{$list_title_name}}</h4>
                </div>
                <form method="post" id="form-validate-submit"
                      class="form-horizontal m-t">
                    <div class="modal-body">
                        @include('backend.costs.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-sm"
                                data-dismiss="modal">关闭
                        </button>
                        {{csrf_field()}}

                        <button type="button" id="cost_save" class="btn btn-primary btn-sm">确认提交
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!--    js    -->
@section('js_code')
    <script>

        $(function () {

            /**
             * 点击修改按钮触发的操作
             */
            $('[data-form="edit-model"]').click(function () {
                var user_id = $(this).attr('data-user_id');
                var name = $(this).attr('data-name');
                var phone = $(this).attr('data-phone');
                var balance = $(this).attr('data-balance');
                var ticket = $(this).attr('data-ticket');

                $('#form_user_id').val(user_id);
                $('#form_name').text(name);
                $('#form_phone').text(phone);
                $('#form_balance').text(balance);
                $('#form_ticket').text(ticket);

            });

            //数据提交
            $('#cost_save').click(function () {

                var cost = {};
                var details = [];
                var sundry = [];

                cost['user_id'] = $('#form_user_id').val();
                cost['last_balance'] = $('#form_balance').text();
                cost['last_ticket'] = $('#form_ticket').text();
                cost['store_id'] = $('#store_id').val()


                $("#costsinfo tr").each(function (i) {

                    var service_id = $(this).find(".serverid").val();
                    var service_num = parseFloat($(this).find("#b_snum" + service_id).text());
                    var ticket_num = parseFloat($(this).find("td").eq(3).html().substring(0, $(this).find("td").eq(3).html().length - 1));

                    var jsonstr = {
                        "service_id": service_id,
                        "service_num": service_num,
                        "ticket_num": ticket_num,
                        "cost_type": 0
                    };
                    details[i] = jsonstr;

                });

                cost['ticket_count'] = parseFloat($('#ticketcount').text().substring(0, $('#ticketcount').text().length - 1));
                cost['money_count'] = parseFloat($('#moneycount').text().substring(1, $('#moneycount').text().length - 1));
                console.log(cost);

                cost['details'] = details;

                var sundry_name = $("#remark").val();
                var sundry_ticket = $("#ticket").val();
                var sundry_money = $("#money").val();
                undry = {
                    "sundry_name": sundry_name,
                    "ticket_num": sundry_ticket,
                    "sundry_money": sundry_money,
                    "cost_type": 1
                };

                cost['sundry'] = sundry;


                var json_data = JSON.stringify(cost);


                $.ajax({
                    type: "post",
                    url: "{{route('backend.costs.save')}}",
                    data: json_data,
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 200) {
                            // alert('录入成功');
                            parent.layer.alert('录入成功')
                            window.location.href = "{{route('backend.costs.index')}}"
                        }else{

                            parent.layer.alert(data.msg);
                            return false;
                        }
                        console.log(data);

                    }
                });
            });


        });

        //计算总价
        function acount() {
            var tickcount = 0;
            var moneycount = 0;

            //杂项的价格
            var mmoney = parseFloat($("#money").val());
            //杂项的门票
            var mticket = parseFloat($("#ticket").val());
            moneycount = moneycount + mmoney;
            tickcount = tickcount + mticket;

            $("#costsinfo tr").each(function () {
                moneycount += parseFloat($(this).find("td").eq(4).html().substring(1));
                tickcount += parseFloat($(this).find("td").eq(3).html().substring(0, $(this).find("td").eq(3).html().length - 1));
            })

            // alert(tickcount);


            // alert(moneycount);

            $("#ticketcount").html(tickcount + "张");

            $("#moneycount").html("¥" + moneycount + ".00");

        }


        $('#money').bind('input propertychange', function () {
            acount();
        });

        $('#ticket').bind('input propertychange', function () {
            acount();
        });

        //添加消费信息到列表
        function addcostsinfo(sid) {

            var sname = $("#s" + sid).data('sname');
            var sprice = $("#s" + sid).data('sprice');
            var sticket = $("#s" + sid).data('sticket');
            var server_id = $("#s" + sid).data('server_id');

            if ($("#b_s" + sid).length > 0) {

                //已有项目做修改
                //获取该元素数量
                var num = $("#b_snum" + sid).html();
                ++num;//+1

                // /alert(num);

                var s_bhtml = "            <td>\n" +
                    "               <input type='hidden' class='serverid' value='" + server_id + "'>\n" +
                    "                <div><strong>" + sname + "</strong>\n" +
                    "                </div>\n" +
                    "            </td>\n" +
                    "            <td id='b_snum" + sid + "'>" + num + "</td>\n" +
                    "            <td>¥<span id=b_sprice" + sid + ">" + sprice + "</span></td>\n" +
                    "            <td>" + sticket * num + "张</td>\n" +
                    "            <td>¥" + sprice * num + ".00</td>\n";


                //alert(s_bhtml);
                $("#b_s" + sid).html(s_bhtml);

            }
            else {

                //若是新的项目

                var html = "<tr id='b_s" + sid + "'>\n" +
                    "            <td>\n" +
                    "               <input type='hidden' class='serverid' value='" + server_id + "'>\n" +
                    "                <div><strong>" + sname + "</strong>\n" +
                    "                </div>\n" +
                    "            </td>\n" +
                    "            <td id='b_snum" + sid + "'>1</td>\n" +
                    "            <td>¥<span id=b_sprice" + sid + ">" + sprice + "</span></td>\n" +
                    "            <td>" + sticket + "张</td>\n" +
                    "            <td>¥" + sprice + "</td>\n" +
                    "        </tr>";

                $("#costsinfo").append(html);
            }
            acount();
        }

        //添加杂项信息
        function addmicinfo() {

        }


    </script>
@endsection