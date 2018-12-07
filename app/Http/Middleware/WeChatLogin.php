<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class WeChatLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->getUser = null;
        $user = session('wechat.oauth_user.default');
        if ($user){
            $openid = $user['id'];  // 对应微信的 OPENID
            $wx_name = $user['nickname']; // 对应微信的 nickname
            $wx_avatar = $user['avatar']; // 头像网址
            $save_data = [
                'wx_name' => $wx_name,
                'wx_avatar' => $wx_avatar,
            ];
            $exist = User::where(['openid' => $openid])->first();
            if ($exist){
                if ($exist['type'] == 1){
                    unset($save_data['wx_name']);
                }
                $uid = $exist['id'];
                User::where(['openid' => $openid])->update($save_data);
            }else{
                $save_data['openid'] = $openid;
                $save_data['status'] = 1;
                $save_data['vip'] = 0;
                $save_data['type'] = 0;
                $res = User::create($save_data);
                $uid = $res['id'];
            }
            if ($uid){
                $request->getUser = [
                    'id' => $uid,
                    'openid' => $openid,
                    'wx_name' => $wx_name,
                    'wx_avatar' => $wx_avatar,
                ];
            }
        }
        return $next($request);
    }

}
