<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Order;
use App\Models\Service as TM;
use App\Models\User;
use App\Models\WeChat;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use EasyWeChat\Factory;

class ServiceController extends BaseController
{
    public function index($id,Request $request){
        $user = $request->getUser;
        $debug = $request->input('debug');
        if ($user){
            $map = [
                'status' => 1,
                'id' => $id,
            ];
            $data = TM::where($map)->orderBy('id','desc')->first();
            $user_list = User::find($user['id']);
            // 是否有营业
//            $work_map = [
//                'store_id' => $data->store_id,
//                'status' => 1,
//            ];
//            $get_work = WorkLog::where($work_map)->orderBy('id','desc')->first();
//            if ($get_work){
//                $is_buy = 'ok';
//            }else{
//                $is_buy = 'fail';
//            }
            // 是否重复购买
            $my_map = [
                'service_id' => $id,
                'status' => 1,
                'customer_id' => $user['id'],
            ];
            $my_order = Order::where($my_map)->orderBy('id','desc')->first();
            if ($my_order){
                $is_exist = 'ok';
            }else{
                $is_exist = 'fail';
            }
            $trade_no = WeChat::generate18NumOrderNo($user['id']);
            if ($data){
                if ($user_list['type'] == 0 && $user_list['vip'] == 1 && $user_list['vip_exp_at'] >= date('Y-m-d')){
                    // 年卡
                    return view('weChat.home.service_info_vip', [
                        'list' => $data,
                        'user_list' => $user_list,
                        'is_exist' => $is_exist,
                        'trade_no' => $trade_no,
                        'title_name' => '核对订单',
                    ]);
                }else{
                    // 微信支付
                    $total_fee = $data->price * 100;
                    $app = Factory::payment(config('wechat.payment.default'));
                    $app_official = Factory::officialAccount(config('wechat.official_account.default'));
                    $order = $app->order->unify([
                        'body' => $data->name,
                        'out_trade_no' => $trade_no,
                        'total_fee' => $total_fee,
                        'trade_type' => 'JSAPI',
                        'openid' => $user['openid'],
                        'notify_url' => url('wechat/payment/orderNotify')
                    ]);
                    if ($order['return_code'] == 'SUCCESS' && $order['result_code'] == 'SUCCESS'){
                        $prepayId = $order['prepay_id'];
                        $jssdk = $app->jssdk;
                        $sdk = $jssdk->sdkConfig($prepayId);
                        return view('weChat.home.service_info', [
                            'list' => $data,
                            'user_list' => $user_list,
                            'is_exist' => $is_exist,
                            'title_name' => '核对订单',
                            'sdk' => $sdk,
                            'app' => $app_official,
                            'trade_no' => $trade_no,
                            'total_fee' => $data->price,
                        ]);
                    }else{
                        if ($debug){
                            return [$order,$total_fee];
                        }
                        abort(404);
                    }
                }
            }else{
                abort(404);
            }
        }else{
            abort(404);
        }
    }
}
