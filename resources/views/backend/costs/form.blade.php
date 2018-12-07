<?php

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

$services_arr = [];
$services_arr = Service::select('id', 'name','price','ticket_num')->where('status', 1)->get();
$admins =     Auth::guard('admin')->user();
$stores =[];
$result = Store::select('id','name')->where('status',1)->get();
if(collect($result)->isNotEmpty()){
    $stores = $result->toArray();
}
?>

<input type="hidden" id="form-id" name="id">
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">用户姓名：</label>
    <div class="col-sm-2">
        <div class="input-group">
            <input type="hidden" id="form_user_id" value=""/>
            <p id="form_name" class="form-control-static"></p>
        </div>

    </div>
    <label class="col-sm-3 control-label">手机号：</label>
    <div class="col-sm-2">
        <div class="input-group">
            <p id="form_phone" class="form-control-static"></p>
        </div>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">当前余额：</label>
    <div class="col-sm-2">
        <div class="input-group m-b">
            <span class="input-group-addon">¥</span>
            <p id="form_balance" class="input-group-addon"></p>
        </div>
    </div>
    <label class="col-sm-3 control-label">当前门票次数：</label>
    <div class="col-sm-2">
        <div class="input-group m-b">
            <p id="form_ticket" class="input-group-addon"></p>
            <span class="input-group-addon">次</span>
        </div>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">消费店铺：</label>
    <div class="col-sm-8">


        <select class="form-control" name="store_id" id="store_id">
            @if(empty($stores))
                <option value="">暂无店铺</option>
            @else
                @foreach($stores as $items)
                    <option value="{{$items['id']}}">{{$items['name']}}</option>
                @endforeach
            @endif
        </select>

    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">消费项目：</label>
    @if(collect($services_arr)->isEmpty())
        <div class="col-sm-9"> <strong>暂无项目</strong></div>
    @endif


    <div class="col-sm-9">
        @foreach($services_arr as $list)
        <div id="s{{$list->id}}" class="btn btn-sm btn-warning m-t-n-xs" onClick="addcostsinfo({{$list->id}})"
             data-server_id="{{$list->id}}"
             data-sname="{{$list->name}}"
             data-sprice="{{$list->price}}"
             data-sticket="{{$list->ticket_num}}"
        >
            <strong>{{$list->name}}</strong>

        </div>
        @endforeach
    </div>

</div>
<div class="table-responsive m-t">
    <table class="table invoice-table">
        <thead>
        <tr>
            <th>清单</th>
            <th>数量</th>
            <th>单价</th>
            <th>门票消耗</th>
            <th>总价</th>
        </tr>
        </thead>
        <tbody id="costsinfo" onclick="acount();">
        {{--<tr>--}}
            {{--<td>--}}
                {{--<div><strong>儿童门票</strong>--}}
                {{--</div>--}}
            {{--</td>--}}
            {{--<td>1</td>--}}
            {{--<td>¥26.00</td>--}}
            {{--<td>2张</td>--}}
            {{--<td>¥31,98</td>--}}
        {{--</tr>--}}
        </tbody>
    </table>
    <table class="table invoice-table">
        <thead>
        <tr>
            <th>消费名称</th>
            <th>消耗门票</th>
            <th>消费金额</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="input-group m-b">
                    <input id="remark" type="text" class="form-control" style="text-align: right">
                </div>
            </td>

            <td>
                <div class="input-group m-b">
                    <input id="ticket" type="number" min="0" max="99" value="0" class="form-control">
                    <span class="input-group-addon">张</span>
                </div>
            </td>
            <td>
                <div class="input-group m-b">
                    <span class="input-group-addon">¥</span>
                    <input id="money" type="number" min="0"  value="0" class="form-control text-right">
                    <span class="input-group-addon">.00</span>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<table class="table invoice-total">
    <tbody>
    <tr>
        <td><strong>门票消耗总计：0 张</strong>
        </td>
        <td id="ticketcount"></td>
    </tr>
    <tr>
        <td><strong>总计消费：</strong>
        </td>
        <td id="moneycount">¥ 0.00</td>
    </tr>
    <tr>
        <td><strong>操作人：</strong>
        </td>
        <td id="adminname" style="width: 25%">{{$admins->name}}</td>
    </tr>
    </tbody>
</table>
