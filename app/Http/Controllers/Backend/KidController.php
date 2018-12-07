<?php

namespace App\Http\Controllers\Backend;

use App\Models\Kids;
use Illuminate\Http\Request;

class KidController extends BaseController
{
    // 孩子信息
    public function index(Request $request){
        $request_name = $request->get('name');
        $kids = new Kids();
        if(isset($request_name)){
            $where[] = ['name', 'like', '%' . $request_name . '%'];
            $kids = $kids->where($where);
        }
        $data = $kids->with('user')->orderBy('id','desc')->paginate(config('params')['pageSize']);

        return view('backend.kid.index', [
            'lists' => $data,
            'list_title_name' => '孩子信息',
            'request_params' => $request,
        ]);
    }



    //保存
    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        // dd($request_all);
        if($id){
            $res = Kids::find($id)->update($request_all);
        }else{
            $res = Kids::create($request_all);
        }
        if($res){
            return $this->ok();
        }else{
            return $this->err('失败');
        }
    }

}
