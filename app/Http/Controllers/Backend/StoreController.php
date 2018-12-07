<?php

namespace App\Http\Controllers\Backend;

use App\Models\Store as ThisModel;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function index(Request $request){
        $request_name = $request->get('name');
        $where = [];
        if($request_name){
            $where[] = ['name', 'like', '%' . $request_name . '%'];
        }
        $data = ThisModel::where($where)->orderBy('id','desc')->paginate(config('params')['pageSize']);

        return view('backend.store.index', [
            'lists' => $data,
            'list_title_name' => '店铺',
            'request_params' => $request,
        ]);
    }

    public function save(Request $request){
        $id = $request->input('id');
        $request_name = $request->input('name');
        $upload_url = $request->input('upload_url');
        if (empty($upload_url)){
            return $this->err('请添加图片');
        }
        $request_all = $request->all();
        if (ThisModel::isExist(['name' => $request_name], $id)){
            return $this->err('店铺已存在');
        }
        if($id){
            $res = ThisModel::find($id)->update($request_all);
        }else{
            $res = ThisModel::create($request_all);
        }
        if($res){
            return $this->ok();
        }else{
            return $this->err('失败');
        }
    }
}
