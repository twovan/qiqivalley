<?php
use App\Models\Store;
$stores =[];
$result = Store::select('id','name')->where('status',1)->get();
if(collect($result)->isNotEmpty()){
    $stores = $result->toArray();
}
?>
{{ csrf_field() }}
<input type="hidden" id="form-id" name="id">

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">用户姓名：</label>
    <div class="col-sm-2">
        <div class="input-group">
            <p id="b_name" class="form-control-static"></p>
            <input type="hidden" id="form-user_id" name="user_id">
        </div>

    </div>
    <label class="col-sm-3 control-label">手机号：</label>
    <div class="col-sm-2">
        <div class="input-group">
            <p id="b_phone" class="form-control-static"> </p>
        </div>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">当前余额：</label>
    <div class="col-sm-2">
        <div class="input-group m-b">
            <span class="input-group-addon">¥</span>
            <span id="last_balance" class="input-group-addon"> </span>
            <input type="hidden" id ="form-last_balance" name="last_balance"/>
        </div>
    </div>
    <label class="col-sm-3 control-label">当前门票次数：</label>
    <div class="col-sm-2">
        <div class="input-group m-b">
            <span id="last_ticket" class="input-group-addon"></span>
            <span class="input-group-addon">次</span>
            <input type="hidden" id ="form-last_ticket" name="last_ticket"/>
        </div>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">充值金额：</label>
    <div class="col-sm-8">
        <div class="input-group m-b"><span class="input-group-addon">¥</span>
            <input id="amount" name="amount" type="number" value="0" class="form-control" style="text-align: right">
            <span class="input-group-addon">.00元</span>
        </div>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">增加门票：</label>
    <div class="col-sm-8">
        <div class="input-group m-b">
            <input id="ticket_num" name="ticket_num" type="number" value="0" class="form-control" style="text-align: right">
            <span class="input-group-addon">张</span>
        </div>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">充值店铺：</label>
    <div class="col-sm-8">


        <select class="form-control" name="store_id" id="form-store_id">
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
    <label class="col-sm-3 control-label">操作人：</label>
    <div class="col-sm-8">
        <p class="form-control-static" id="form-admin_name"></p>
            <input type="hidden" id="form-admin_id" name="admin_id">
    </div>
</div>

