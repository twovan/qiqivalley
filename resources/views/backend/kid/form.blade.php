
{{ csrf_field() }}
<input type="hidden" id="form-id" name="id">
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">姓名</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="name" id="form-name">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">性别</label>
    <div class="col-sm-8">
        <select class="form-control" name="sex" id="form-sex">
            <option value="0">男</option>
            <option value="1">女</option>
        </select>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">出生日期</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="DOB" id="form-DOB">
    </div>
</div>

