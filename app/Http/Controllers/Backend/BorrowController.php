<?php

namespace App\Http\Controllers\Backend;

use App\Models\Borrow;
use App\Models\Store;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends BaseController
{
    //查询所有店铺信息
    public function getSoresList(){
        $responses =[];
        $result = Store::select('id','name')->where('status',1)->get();
        if(collect($result)->isNotEmpty()){
            $responses = $result->toArray();
        }
        return $responses;
    }

    // 借阅信息
    public function index(Request $request){
        $result =[];
        $request_name = $request->get('b_name');
        $borrows = new Borrow();
        $borrows = $borrows->with(['store', 'user','admin']);

        $user_id = [];
        if(isset($request_name)){
            $user = new User();
            $user_id = $user->where('phone','like','%'.$request_name.'%')->pluck('id')->all();
            $borrows = $borrows->whereIn('user_id',$user_id);
        }
        $data = $borrows->orderBy('id','desc')->paginate(config('params')['pageSize']);




        return view('backend.borrow.index', [
            'lists' => $data,
            'list_title_name' => '借阅信息',
            'request_params' => $request,
        ]);
    }



    //保存
    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        $phone = $request_all['phone'];
        $search_phone = User::where('phone',$phone)->first();

        if(collect($search_phone)->isEmpty()){
            return $this->err('该电话不存在，请在用户管理中绑定!');
        }
        $search_phone = $search_phone->toArray();
        $user_id = $search_phone['id'];
        $admin_id = Auth::guard('admin')->id();
        unset($request_all['phone']);
        $request_all['user_id'] = $user_id;
        $request_all['admin_id'] = $admin_id;
        // dd($request_all);
        if($id){
            $res = Borrow::find($id)->update($request_all);
        }else{
            $res = Borrow::create($request_all);
        }
            if($res){
                return $this->ok();
            }else{
            return $this->err('失败');
        }
    }

}
