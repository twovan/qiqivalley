<?php

namespace App\Models;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Database\Eloquent\Model;

class WeChat extends Model
{

    // 生成18位号
    public static function generate18NumOrderNo($id = 1){
        $len = 18;
        $res = date('YmdH').$id;
        $for_len = $len-strlen($res);
        $rand_num = rand(100000000,999999999);
        for($i=0; $i< $for_len; $i++){
            $res .= substr($rand_num,$i,1);
        }
        return $res;
    }

    // 回调
    public function storeOrder(){

    }

    public static function notice($openId, $text)
    {
        $config = config('wechat.official_account.default');
        $app = Factory::officialAccount($config);
        $user = $app->user->get($openId);
        if ($user && $user['subscribe'] == 1){
            $message = new Text($text);
            $result = $app->customer_service->message($message)->to($openId)->send();
            if ($result['errcode'] == 'ok'){
                return true;
            }
        }
        return false;
    }

}
