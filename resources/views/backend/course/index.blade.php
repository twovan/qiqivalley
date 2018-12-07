@extends('backend.layout.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox widget-box float-e-margins">
                <div class="ibox-title no-borders">
                    <form role="form" class="form-inline">
                        <div class="form-group form-group-sm">
                            <label>课程名称：</label>
                            <input type="text" name="b_name" value="{{$request_params->courses_name}}"
                                   class="form-control">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">查询</button>

                    </form>
                </div>

                <div class="ibox-title clearfix">
                    <h5>{{$list_title_name}}
                        <small>列表</small>
                    </h5>

                </div>
                <div class="ibox-content">

                    <table class="table table-stripped toggle-arrow-tiny" data-sort="false">
                        <thead>
                        <tr>
                            <th>课程名称</th>
                            <th>上课时间</th>
                            <th>上课人数</th>
                            <th>任课老师</th>
                            <th>使用耗材</th>

                        </tr>
                        </thead>

                        <tbody>
                        @if(collect($lists)->isEmpty())
                            <tr>
                                <td colspan="8">暂无记录</td>
                            </tr>
                        @endif
                        @foreach($lists as $list)
                            @if($list->user_id)
                                <tr>
                                    <td>{{$list->courses_name}}</td>
                                    <td>{{$list->courses_ts}}</td>
                                    <td>{{$list->courses_num}}</td>
                                    @if(collect($list->user)->isNotEmpty())
                                        <td>{{$list->user->name}}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    <td>
                                        <p>
                                            耗材使用：
                                            <?php
                                            $details = '';
                                            $materialdetails = $list->materialdetail;
                                            foreach ($materialdetails as $itmes) {
                                                $material_id = $itmes->material_id;
                                                $num = $itmes->num;
                                                $material_name = $material_arr[$material_id];
                                                $details .= $material_name . '*' . $num . '、';
                                            }

                                            echo trim($details, '、');
                                            ?>
                                        </p>

                                    </td>
                                    <td>
                                        <button class="btn btn-white btn-xs" data-form="edit-model" data-toggle="modal"
                                                data-target="#formModal"
                                                data-id="{{$list->id}}"
                                                data-courses_name="{{$list->courses_name}}"
                                                data-courses_ts="{{$list->courses_ts}}"
                                                data-courses_num="{{$list->courses_num}}"
                                                data-user_name="{{$list->user->name}} "
                                                data-user_id="{{$list->user_id}} "
                                                data-materialdetail="{{$list->materialdetail}} "
                                        >修改
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                    {{$lists->appends($request_params->all())->render()}}

                </div>

            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">{{$list_title_name}}编辑</h4>
                </div>
                <form method="post" id="form-validate-submit" class="form-horizontal m-t">
                    <div class="modal-body">
                        @include('backend.course.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary btn-sm">保存</button>
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
            var form_url = '{{route('backend.course.save')}}';
            var index_url = window.location.href;
            var rules = [];
            subActionAjaxValidateForMime('#form-validate-submit', rules, form_url, index_url);


            /**
             * 点击修改按钮触发的操作
             */
            $('[data-form="edit-model"]').click(function () {
                var id = $(this).attr('data-id');
                var course_name= $(this).attr('data-courses_name');

                var course_ts = $(this).attr('data-courses_ts');
                var course_num = $(this).attr('data-courses_num');
                var user_name = $(this).attr('data-user_name');
                var user_id = $(this).attr('data-user_id');
                var materialdetail = $(this).attr('data-materialdetail');


                $('#form-id').val(id);
                $('#form-course_name').val(course_name);
                $('#form-course_ts').val(course_ts);
                $('#form-course_num').val(course_num);
                $('#form-user_name').val(user_name);
                $('#form-user_id').val(user_id);
                $('#form-materialdetail').val(materialdetail);

            });

            var var_course_ts = {
                elem: "#form-course_ts",
                format: "YYYY/MM/DD hh:mm:ss",
                min: "2010-01-01",
                max: "2037-12-31",
                istime: true,
                istoday: false,
                choose: function (datas) {
                }
            };
            laydate(var_course_ts);



        });

    </script>
@endsection