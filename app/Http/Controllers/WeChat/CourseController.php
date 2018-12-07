<?php

namespace App\Http\Controllers\WeChat;

use App\Models\MaterialDetail;
use App\Models\WeChat;
use App\Models\Course;
use App\Models\User;
use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\DB;

class CourseController extends BaseController
{
    protected $official_config;
    protected $payment_config;

    public function __construct()
    {
        parent::__construct();
        $this->official_config = config('wechat.official_account.default');
        $this->payment_config = config('wechat.payment.default');
    }



    //员工增加课程记录
    public function addCourseInfo(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $res = User::find($user['id']);
            //耗材列表
            $material = Material::select('id','material_name')->get();
            return view('weChat.course.add_courseinfo', [
                'list' => $res,
                'title_name' => '增加会员记录',
                'material'=>$material,
            ]);
        } else {
            abort(404);
        }
    }

    //员工查看课程记录
    public function getCourseInfo(Request $request)
    {
        $user = $request->getUser;
        if ($user) {

            $res = Course::where('user_id',$user['id'])->with('user','materialdetail')->get();

            $materials= Material::get(['id','material_name']);
            $materialArr =[];
            if(collect($materials)->isNotEmpty()){
                $material = collect($materials)->toArray();
                foreach ($material as $item){
                    $materialArr[$item['id']]=$item['material_name'];
                }
            }

            return view('weChat.course.check_course', [
                'list' => $res,
                'material_arr'=>$materialArr,
                'title_name' => '查看课程记录',
            ]);
        } else {
            abort(404);
        }
    }

    //保存课程记录
    public function saveCourseInfo(Request $request)
    {
        $user = $request->getUser;
        $data = [];
        if ($user) {
            $requst_parms = $request->all();

            DB::beginTransaction(); //开启事务
            try{
                //添加课程
                $data_course =[
                    'user_id'=>$user['id'],
                    'courses_name'=>$requst_parms['courses_name'],
                    'courses_ts'=>$requst_parms['courses_ts'],
                    'courses_num'=>$requst_parms['courses_num'],
                ];
                $Course = Course::create($data_course);

                $course_id = $Course->id;

                //添加耗材使用明细
                if(!empty($course_id)&&!empty($requst_parms['material'])){
                    //$data_detail=[];


                    foreach ($requst_parms['material'] as $item) {
                        //dd($material);
                        $data_detail = [
                            'courses_id' => $course_id,
                            'material_id' => $item['material_id'],
                            'num' => $item['num'],
                        ];
                        MaterialDetail::create($data_detail);
                    }

                }
                DB::commit();
            }catch (\Exception $e){
                //echo $e->getMessage();
                DB::rollback();//回滚
                back();

            }

            return redirect('wechat/course/courseinfo');

        } else {
            abort(404);
        }
        //dd($request->all());
    }




}
