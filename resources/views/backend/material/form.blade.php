
{{ csrf_field() }}
<input type="hidden" id="form-id" name="id">
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">耗材名称</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="material_name" id="form-material_name" required>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">备注</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="remark" id="form-remark" >
    </div>
</div>



