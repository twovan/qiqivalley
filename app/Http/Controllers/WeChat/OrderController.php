<?php

namespace App\Http\Controllers\WeChat;

use App\Models\HairStyle;
use App\Models\Order as TM;
use App\Models\User;
use App\Models\WeChat;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use EasyWeChat\Factory;

class OrderController extends BaseController
{
    protected $official_config;

    public function __construct(){
        parent::__construct();
        $this->official_config = config('wechat.official_account.default');
    }

    /**
     * 订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $order_status = $request->input('status');
        $user = $request->getUser;
        if ($user){
            $get_user = User::find($user['id']);
            if ($get_user['type'] == 1){
                $store_orders = [];
                if ($order_status < 2){
                    // 门店订单
                    $work_map = [
                        'barber_id' => $user['id'],
                        'status' => 1,
                    ];
                    $get_work = WorkLog::where($work_map)->orderBy('id','desc')->first();
                    if ($get_work){
                        $store_orders = TM::where(['store_id' => $get_work->store_id, 'status' => 1])->orderBy('id','asc')->get();
                    }
                }
                $map = [
                    'barber_id' => $user['id'],
                ];
                if ($order_status){
                    $map['status'] = $order_status;
                }else{
                    $map[] = ['status', '>', 1];
                }
                $data = TM::where($map)->orderBy('id','desc')->get();
                $app = Factory::officialAccount($this->official_config);
                return view('weChat.order.list_barber', [
                    'lists' => $data,
                    'app' => $app,
                    'request_status' => $order_status ?? 0,
                    'store_orders' => $store_orders,
                    'title_name' => '订单列表',
                ]);
            }else{
                $map = [
                    'customer_id' => $user['id'],
                ];
                if ($order_status){
                    $map['status'] = $order_status;
                }else{
                    $map[] = ['status', '>', 0];
                }
                $data = TM::where($map)->orderBy('id','desc')->get();

                return view('weChat.order.list', [
                    'lists' => $data,
                    'request_status' => $order_status ?? 0,
                    'title_name' => '历史记录',
                ]);
            }
        }else{
            abort(404);
        }
    }

    public function info($id, Request $request)
    {
        $user = $request->getUser;
        if ($user){
            $get_user = User::find($user['id']);
            if ($get_user['type'] == 1){
                $map = [
                    'id' => $id,
                ];
                $data = TM::where($map)->first();
                if (empty($data)){
                    abort(404);
                }
                $app = Factory::officialAccount($this->official_config);
                return view('weChat.order.info_barber', [
                    'list' => $data,
                    'app' => $app,
                    'title_name' => '订单详情',
                ]);
            }else{
                $map = [
                    'customer_id' => $user['id'],
                    'id' => $id,
                ];
                $data = TM::where($map)->first();
                if (empty($data)){
                    abort(404);
                }
                $hs_lists = HairStyle::where(['status' => 1])->orderBy('id','desc')->get();
                $qrCode = $data['order_no'];
                return view('weChat.order.info', [
                    'list' => $data,
                    'hs_lists' => $hs_lists,
                    'qrCode' => $qrCode,
                    'title_name' => '订单详情',
                ]);
            }
        }else{
            abort(404);
        }

    }


    public function add(Request $request)
    {
        $user = $request->getUser;
        $store_id = $request->input('store_id');
        $service_id = $request->input('service_id');
        $pay_type = $request->input('pay_type');
        $order_no = $request->input('trade_no');
        $pay_fee = $request->input('pay_fee');
        if ($user){
//            $work_map = [
//                'store_id' => $store_id,
//                'status' => 1,
//            ];
//            $get_work = WorkLog::where($work_map)->orderBy('id','desc')->first();
//            if (empty($get_work)){
//                return self::err('该店处于非营业状态，请稍后重试');
//            }
            $order_map = [];
            $order_map[] = ['status', '>' , 0];
            $order_map[] = ['created_at', '>' , date('Y-m-d')];
            $order_count = TM::where($order_map)->count();
            $data = [
                'order_no' => $order_no,
                'queue_no' => date('d') . ($order_count + 1),
                'customer_id' => $user['id'],
                'store_id' => $store_id,
                'service_id' => $service_id,
                'pay_type' => $pay_type,
                'pay_fee' => $pay_fee,
                'pay_at' => Carbon::now(),
                'status' => -1,
            ];
            if ($pay_type == 'yearCard'){
                $data['status'] = 1;
            }elseif ($pay_type == 'wxPay'){
                $app = Factory::payment(config('wechat.payment.default'));
                $wx_order = $app->order->queryByOutTradeNumber($order_no);
                if ($wx_order['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                    // 用户是否支付成功
                    if (array_get($wx_order, 'result_code') === 'SUCCESS' && array_get($wx_order, 'trade_state') === 'SUCCESS') {
                        $data['status'] = 1;
                    }
                }
            }
            $res = TM::create($data);
            if ($res){
                return self::ok();
            }else{
                return self::err('操作失败');
            }
        }else{
            return self::err('操作失败');
        }
    }

    public function serviceOk(Request $request)
    {
        $user = $request->getUser;
        $id = $request->input('id');
        $order_no = $request->input('order_no');
        $store_id = $request->input('store_id');
        if ($user){
            $map = [
                'order_no' => $order_no,
                'store_id' => $store_id,
                'id' => $id,
            ];
            $res = TM::where($map)->update(['status' => 2,'barber_id' => $user['id'], 'finished_at' => Carbon::now()]);
            if ($res){
                $order_map = [
                    'store_id' => $store_id,
                    'status' => 1,
                ];
                $order_lists = TM::where($order_map)->orderBy('id','asc')->limit(3)->get();
                if ($order_lists){
                    foreach ($order_lists as $key => $order_list){
                        if ($key == 0){
                            WeChat::notice($order_list->customer->openid, '您好，即将为您服务');
                        }else{
//                            WeChat::notice($order_list->customer->openid, '您好，您前面还有'.$key.'位，大约需要等待'.($key*20).'分钟');
                            WeChat::notice($order_list->customer->openid, '您好，您前面还有'.$key.'位顾客');
                        }
                    }
                }
                return self::ok();
            }else{
                return self::err('操作失败');
            }
        }else{
            return self::err('操作失败');
        }

    }

}
