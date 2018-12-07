
{{ csrf_field() }}
<input type="hidden" id="form-id" name="id">
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">所属门店</label>
    <div class="col-sm-8">
        <select class="form-control" name="store_id" id="form-store_id" required>
            @foreach($stores as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">名称</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="name" id="form-name" required>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">价格</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="price" id="form-price" required>
    </div>
</div>

<div class="form-group form-group-sm">
<label class="col-sm-3 control-label">门票数</label>
<div class="col-sm-8">
    <input type="text" class="form-control" name="ticket_num" id="form-ticket_num" required>
</div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">简介</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="remark" id="form-remark" required>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">图片<small class="text-danger" style="font-weight: normal">(大小不要超过2M)</small></label>
    <div class="col-sm-8">
        @include('backend.layout.upload', [
        'modelName' => 'upload_url',
        'modelIdName' => 'upload_id',
        'inputId' => 'one',
        'actionCtrl' => 'uploadImg',
        'uploadPath' => 'service',
        ])
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">状态</label>
    <div class="col-sm-8">
        <select class="form-control" name="status" id="form-status">
            @foreach(config('params')['status'] as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>

