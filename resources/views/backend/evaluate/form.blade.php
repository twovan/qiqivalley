
{{ csrf_field() }}
<input type="hidden" id="form-id" name="id">
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">服务评级</label>
    <div class="col-sm-8">
        <select class="form-control" name="star" id="form-star">
            @foreach(config('params')['evaluateStar'] as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">评价内容</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="content" id="form-content">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">评价状态</label>
    <div class="col-sm-8">
        <select class="form-control" name="status" id="form-status">
            @foreach(config('params')['status'] as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>

