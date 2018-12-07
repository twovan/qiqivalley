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
    <label class="col-sm-3 control-label">物品名称</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="b_name" id="form-b_name" required>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">借阅人电话</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="phone" id="form-phone" required>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">借阅时间</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="borrow_ts" id="form-borrow_ts" required>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">归还时间</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="back_ts" id="form-back_ts">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">店铺名称</label>
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


