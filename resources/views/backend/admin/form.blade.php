
{{ csrf_field() }}
<input type="hidden" id="form-id" name="id">
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">名称</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="name" id="form-name" required>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">用户名</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="username" id="form-username" required>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">密码</label>
    <div class="col-sm-8">
        <input type="password" class="form-control" name="password" placeholder="留空则不修改">
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

