<?php

namespace App\Http\Controllers\Backend;

use App\Models\User as ThisModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    // 用户
    public function customer(Request $request){

        $request_phone = $request->get('phone');
        $request_name = $request->get('name');

        $where = [
            'type' => 0,
        ];
        if($request_phone){
            $where[] = ['phone', 'like', '%' . $request_phone . '%'];
        }elseif ($request_name){
            $where[] = ['name', 'like', '%' . $request_name . '%'];
        }else{

        }

        $data = ThisModel::where($where)->with('kids')->orderBy('id','desc')->paginate(config('params')['pageSize']);
        $admins = Auth::guard('admin')->user();
        return view('backend.customer.index', [
            'lists' => $data,
            'list_title_name' => '用户',
            'admins'=>$admins,
            'request_params' => $request,
        ]);
    }

    // 员工
    public function barber(Request $request){
        $request_phone = $request->get('phone');
        $where = [
            'type' => 1,
        ];
        if($request_phone){
            $where[] = ['phone', 'like', '%' . $request_phone . '%'];
        }
        $data = ThisModel::where($where)->orderBy('id','desc')->paginate(config('params')['pageSize']);

        return view('backend.barber.index', [
            'lists' => $data,
            'list_title_name' => '员工',
            'request_params' => $request,
        ]);
    }


    //保存
    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        // dd($request_all);
        if (ThisModel::isExist(['phone' => $request_all['phone']], $id)){
            return $this->err('手机号已存在');
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
