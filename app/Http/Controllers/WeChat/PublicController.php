<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Order;
use App\Models\User;
use App\Models\VipCardLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;

class PublicController extends Controller
{
    public function serve()
    {
        $app = app('wechat.official_account');
        $app->server->push(function($message){
            $msg = null;
            switch ($message['MsgType']) {
                case 'event':
                    $msg = $this->responseEvent($message);
                    break;
            }
            if ($msg){
                return $msg;
            }
        });
        return $app->server->serve();
    }

    protected function responseEvent($message){
        if (strtolower($message['Event']) == 'subscribe'){
            return '欢迎关注合理先生';
        }
        return false;
    }

    public function vipCardNotify(){
        $app = Factory::payment(config('wechat.payment.default'));
        $response = $app->handlePaidNotify(function ($message, $fail) {
            $order_map = [
                'trade_no' => $message['out_trade_no'],
            ];
            $order = VipCardLog::where($order_map)->first();
            if ($order){
                if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                    // 用户是否支付成功
                    if (array_get($message, 'result_code') === 'SUCCESS') {
                        $save_order = VipCardLog::where(['trade_no' => $message['out_trade_no']])->update([
                            'status' => 1,
                        ]);
                        $save_user = User::where(['id' => $order['user_id']])->update([
                            'vip' => 1,
                            'vip_exp_at' => Carbon::tomorrow()->addYear(),
                        ]);
                        if ($save_order && $save_user){
                            return true;
                        }else{
                            return $fail('通信失败，请稍后再通知我');
                        }
                    } else {
                        return $fail('支付失败，请稍后重试');
                    }
                } else {
                    return $fail('通信失败，请稍后再通知我');
                }
            }else{
                return $fail('通信失败，请稍后再通知我');
            }
        });
        return $response;
    }

    public function orderNotify(){
        $app = Factory::payment(config('wechat.payment.default'));
        $response = $app->handlePaidNotify(function ($message, $fail) {
            $order_map = [
                'order_no' => $message['out_trade_no'],
            ];
            $order = Order::where($order_map)->first();
            if ($order){
		if ($order->status >= 1){
                    return true;
                }
                if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                    // 用户是否支付成功
                    if (array_get($message, 'result_code') === 'SUCCESS') {
                        $save_order = Order::where(['order_no' => $message['out_trade_no']])->update([
                            'status' => 1,
                            'pay_at' => Carbon::now(),
                        ]);
                        if ($save_order){
                            return true;
                        }else{
                            return $fail('通信失败，请稍后再通知我');
                        }
                    } else {
                        return $fail('支付失败，请稍后重试');
                    }
                } else {
                    return $fail('通信失败，请稍后再通知我');
                }
            }else{
                return $fail('通信失败，请稍后再通知我');
            }
        });
        return $response;
    }

    public function test(){

    }
}
