<?php

namespace App\Http\Controllers\Backend;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    // 登录
    public function loginGet(){
        return view('backend.public.login');
    }





    // 登录
    public function loginPost(Request $request){
        $username = $request->post('username');
        $password = $request->post('password');
        if (empty($username)) {
            return $this->err('用户名不能为空');
        }
        if (empty($password)) {
            return $this->err('密码不能为空');
        }
        $credentials = [
            'username' => $username,
            'password' => $password,
        ];
        // 如果被禁用则不能登录
        $param_exist = [
            'username' => $credentials['username'],
        ];
        $username_exist = Admin::isStatus($param_exist);
        if ($username_exist == null){
            return $this->err('用户不存在');
        }
        if ($username_exist == 'disable'){
            return $this->err('用户被禁用');
        }
        if (Auth::guard('admin')->attempt($credentials)){
            return $this->ok();
        }else{
            return $this->err('登录失败');
        }
    }

    //退出
    public function logout(){
        Auth::guard('admin')->logout();
        session()->forget('url.intented');
        return redirect(route('backend.loginGet'));
    }
}
