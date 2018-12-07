<?php

namespace App\Http\Controllers\Index;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function store($id,Request $request)
    {
        $map = [
            'status' => 1,
            'id' => $id,
        ];
        $qrCode = url('wechat/store',['id' => $id]).'?work_hard=1';
        $data = Store::where($map)->first();
        $order_map = [
            'store_id' => $id,
            'status' => 1,
        ];
        $order_lists = Order::where($order_map)->orderBy('id','asc')->get();
        $order_count = $order_lists->count();
        $get_work_lists = WorkLog::where(['store_id' => $id, 'status' => 1])->orderBy('id','asc')->get();
        if ($data){
            return view('index.public.web', [
                'list' => $data,
                'qrCode' => $qrCode,
                'order_lists' => $order_lists,
                'order_count' => $order_count,
                'get_work_lists' => $get_work_lists,
                'title_name' => '店铺展示',
            ]);
        }else{
            abort(404);
        }
    }


	//店铺展示
	public function showstore($id,Request $request){
		return view('index.public.showstore', [
			'id' => $id,
			'title_name' => '店铺展示',
		]);
    }

    //合理屋视频介绍
    public function video(){
        return view('index.video.video');
    }


    // 登录
    public function loginGet(){
        return view('index.public.login');
    }

    // 登录
    public function loginPost(Request $request){
        $phone = $request->post('phone');
        if (empty($phone)) {
            return $this->err('手机号不能为空');
        }
        $credentials = [
            'phone' => $phone,
            'type' => 0,
        ];
        $user = User::where($credentials)->first();
        if ($user){
            Auth::guard('user')->login($user);
            if (Auth::guard('user')->check()){
                return $this->ok();
            }else{
                return $this->err('登录失败');
            }
        }else{
            return $this->err('手机号不存在');
        }
    }

    //退出
    public function logout(){
        Auth::guard('user')->logout();
        session()->forget('url.intented');
        return redirect(route('index.loginGet'));
    }

}
