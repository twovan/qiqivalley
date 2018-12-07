<?php

namespace App\Http\Controllers\Backend;

use App\Models\Admin as ThisModel;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    public function index(Request $request){
        $request_name = $request->get('name');
        $request_username = $request->get('username');
        $where = [];
        if($request_name){
            $where[] = ['name', 'like', '%' . $request_name . '%'];
        }
        if($request_username){
            $where['username'] = $request_username;
        }
        $data = ThisModel::where($where)->orderBy('id','desc')->paginate(config('params')['pageSize']);

        return view('backend.admin.index', [
            'lists' => $data,
            'list_title_name' => '管理员',
            'request_params' => $request,
        ]);
    }

    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        if (ThisModel::isExist(['username' => $request_all['username']], $id)){
            return $this->err('用户名已存在');
        }
        if (isset($request_all['password'])){
            $request_all['password'] = bcrypt($request_all['password']);
        }
        if($id){
            $user = ThisModel::find($id)->update($request_all);
        }else{
            $user = ThisModel::create($request_all);
        }
        if($user){
            return $this->ok();
        }else{
            return $this->err('失败');
        }
    }

}
