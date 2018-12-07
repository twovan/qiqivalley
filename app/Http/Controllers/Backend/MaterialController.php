<?php

namespace App\Http\Controllers\Backend;

use App\Models\Borrow;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends BaseController
{


    // 耗材查询信息
    public function index(Request $request){
        $request_name = $request->get('material_name');
        $material = new Material();
        if(isset($request_name)){
            $where[] = ['material_name', 'like', '%' . $request_name . '%'];
            $material = $material->where($where);
        }
        $data = $material->orderBy('id','desc')->paginate(config('params')['pageSize']);

        return view('backend.material.index', [
            'lists' => $data,
            'list_title_name' => '耗材管理',
            'request_params' => $request,
        ]);
    }



    //保存
    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        // dd($request_all);
        if($id){
            $res = Material::find($id)->update($request_all);
        }else{
            $res = Material::create($request_all);
        }
            if($res){
                return $this->ok();
            }else{
            return $this->err('失败');
        }
    }

}
