<?php

namespace App\Http\Controllers\Backend;

use App\Models\Course;
use App\Models\User;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends BaseController
{

    // 借阅信息
    public function index(Request $request){
        $result =[];
        $request_name = $request->get('b_name');

        $course= new Course();
        if(isset($request_name)){
            $where[] = ['courses_name', 'like', '%' . $request_name . '%'];
            $course = $course->where($where);
           //s dd($request_name);
        }
        $data = $course->with('user','materialdetail')->orderBy('id','desc')->paginate(config('params')['pageSize']);

        $materials= Material::get(['id','material_name']);
        $materialArr =[];
        if(collect($materials)->isNotEmpty()){
            $material = collect($materials)->toArray();
            foreach ($material as $item){
                $materialArr[$item['id']]=$item['material_name'];
            }
        }

        return view('backend.course.index', [
            'lists' => $data,
            'material_arr'=>$materialArr,
            'list_title_name' => '课程信息',
            'request_params' => $request,
        ]);
    }



    //保存
    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        unset($request_all['_token']);


        if($id){
            $res = Course::find($id)->update($request_all);
        }else{
            $res = Course::create($request_all);
        }
            if($res){
                return $this->ok();
            }else{
            return $this->err('失败');
        }
    }

}
