<?php

namespace App\Http\Controllers\Backend;

use App\Models\Service as ThisModel;
use App\Models\Store;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    public function index(Request $request){
        $request_name = $request->get('name');
        $where = [];
        if($request_name){
            $where[] = ['name', 'like', '%' . $request_name . '%'];
        }
        $data = ThisModel::where($where)->orderBy('id','desc')->paginate(config('params')['pageSize']);
        $stores = Store::where(['status' => 1])->get();
        return view('backend.service.index', [
            'lists' => $data,
            'stores' => $stores,
            'list_title_name' => '服务',
            'request_params' => $request,
        ]);
    }

    public function save(Request $request){
        $id = $request->input('id');
        $upload_url = $request->input('upload_url');
        if (empty($upload_url)){
            return $this->err('请添加图片');
        }
        $request_all = $request->all();
        //dd($request_all);

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
