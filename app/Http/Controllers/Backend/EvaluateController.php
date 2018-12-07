<?php

namespace App\Http\Controllers\Backend;

use App\Models\Evaluate as ThisModel;
use Illuminate\Http\Request;

class EvaluateController extends BaseController
{
    public function index(Request $request){
        $request_content = $request->get('content');
        $where = [];
        if($request_content){
            $where[] = ['content', 'like', '%' . $request_content . '%'];
        }
        $data = ThisModel::where($where)->orderBy('id','desc')->paginate(config('params')['pageSize']);

        return view('backend.evaluate.index', [
            'lists' => $data,
            'list_title_name' => '用户评价',
            'request_params' => $request,
        ]);
    }

    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        $res = ThisModel::find($id)->update($request_all);
        if($res){
            return $this->ok();
        }else{
            return $this->err('失败');
        }
    }
}
