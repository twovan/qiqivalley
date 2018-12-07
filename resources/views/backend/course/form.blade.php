
{{ csrf_field() }}
<input type="hidden" id="form-id" name="id">
<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">课程名称</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="courses_name" id="form-course_name" required>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">上课时间</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="courses_ts" id="form-course_ts" required>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">上课人数</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="courses_num" id="form-course_num" required>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-sm-3 control-label">任课老师</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="user_name" id="form-user_name" required>
        <input type="hidden" class="form-control" name="user_id" id="form-user_id" required>

    </div>
</div>


