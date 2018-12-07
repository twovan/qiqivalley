<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 成功返回状态
    public static function ok($data = null, $msg = 'success')
    {
        return ['code' => 200, 'msg' => $msg, 'data' => $data];
    }

    // 失败返回状态
    public static function err($msg = 'error',$err_code = '')
    {
        return ['code' => 0, 'msg' => $msg, 'err_code' => $err_code];
    }

    public static function check_phone($phone)
    {
        return preg_match('/^1[3456789]\d{9}$/', $phone);
    }


    protected static function code($len = 4)
    {
        $str = '1234567890';
        $res = '';
        for ($i = 0; $i < $len; $i++){
            $j = mt_rand(0, strlen($str)-1);
            $res .= substr($str, $j, 1);
        }
        return $res;
    }

    // 检验短信验证码
    protected function check_vCode($phone,$vcode)
    {
        if ($phone && $vcode){
            $value = Cache::get('vcode_'.$phone);
            if ($value == $vcode){
                return true;
            }
        }
        return false;
    }


    protected function sendSmsVCode($phone,$vcode){
        $config = config('params')['sms'];
        $easySms = new EasySms($config);
        $res = $easySms->send($phone, [
            'template' => $config['vcode_template_id'],
            'data' => [
                $vcode, $config['cache_vcode_exp'],
            ],
        ]);
        if ($res['yuntongxun']['status'] == 'success'){
            return true;
        }else{
            return false;
        }
    }

}
