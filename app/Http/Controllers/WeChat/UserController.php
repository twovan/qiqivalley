<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Evaluate;
use App\Models\Kids;
use App\Models\Order;
use App\Models\User;
use App\Models\VipCardLog;
use App\Models\WeChat;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use EasyWeChat\Factory;

class UserController extends BaseController
{
    protected $official_config;
    protected $payment_config;

    public function __construct()
    {
        parent::__construct();
        $this->official_config = config('wechat.official_account.default');
        $this->payment_config = config('wechat.payment.default');
    }

    // 用户中心
    public function index(Request $request)
    {
        $user = $request->getUser;
        $isworker = false;
        if ($user) {
            $res = User::find($user['id']);
            $isworker = false;
            if ($res['type'] == 1) {
                $isworker = true;
            }
            return view('weChat.ucenter.user_center', [
                'list' => $res,
                'title_name' => '个人中心',
                'isworker' => $isworker
            ]);


        } else {
            abort(404);
        }
    }

    //更改手机号
    public function edit_phone(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $res = User::find($user['id']);
            return view('weChat.ucenter.edit_phone', [
                'list' => $res,
                'title_name' => '更改手机号',
            ]);
        } else {
            abort(404);
        }
    }


    //查看员工中心
    public function barber_center(Request $request)
    {
        $user = $request->getUser;
        $isworker = false;
        if ($user) {
            $res = User::find($user['id']);
            if ($res['type'] == 1) {
                // 员工
                $isworker = true;
                $work_map = [
                    'barber_id' => $user['id'],
                ];
                $get_work = WorkLog::where($work_map)->orderBy('updated_at', 'desc')->first();
                // 今天完成的订单数
                $today_map = [
                    'barber_id' => $user['id'],
                ];
                $today_map[] = ['finished_at', '>', Carbon::today()];
                $today_map[] = ['status', '>=', 2];
                $today_work_count = Order::where($today_map)->count();
                // 是否有未完成的订单
//                $finish_map = [
//                    'barber_id' => $user['id'],
//                    'status' => 1,
//                ];
//                $no_finish_count = Order::where($finish_map)->count();
                $app = Factory::officialAccount($this->official_config);
                return view('weChat.ucenter.barber_center', [
                    'list' => $res,
                    'app' => $app,
                    'get_work' => $get_work,
                    'today_work_count' => $today_work_count,
                    'no_finish_count' => false,
                    'title_name' => '员工中心',
                    'isworker' => $isworker,
                ]);
            }

        } else {
            abort(404);
        }
    }


    //查看会员资料
    public function memberinfo(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $res = User::with('kids')->find($user['id']);
            return view('weChat.ucenter.memberinfo', [
                'list' => $res,
                'title_name' => '会员资料',
            ]);
        } else {
            abort(404);
        }
    }


    //修改会员资料
    public function edit_memberinfo(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $res = User::with('kids')->find($user['id']);
            return view('weChat.ucenter.edit_memberinfo', [
                'list' => $res,
                'title_name' => '更改会员资料',
            ]);
        } else {
            abort(404);
        }
    }

    //保存会员资料
    public function saveMemberinfo(Request $request)
    {
        $user = $request->getUser;
        $data = [];
        if ($user) {
            $requst_parms = $request->all();
            User::where('id', $user['id'])->update(['name' => $requst_parms['name']]);

            if (!empty($requst_parms['kids'])) {
                //return response()->json($requst_parms['kids']);
                //先删除再添加
                try {
                    Kids::where('p_id', $user['id'])->delete();
                    foreach ($requst_parms['kids'] as $kid) {
                        $data[] = [
                            'p_id' => $user['id'],
                            'name' => $kid['name'],
                            'sex' => $kid['sex'],
                            'DOB' => $kid['dob'],
                        ];
                    }
                    Kids::insert($data);
                } catch (\Exception $ex) {
                    back();
                }


            }
            return redirect('wechat/user/memberinfo');

        } else {
            abort(404);
        }
        //dd($request->all());
    }




    public function update_phone(Request $request)
    {
        $phone = $request->input('phone');
        $vcode = $request->input('vcode');
        $user = $request->getUser;
        if ($user) {
            if (!self::check_phone($phone)) {
                return self::err('手机号格式错误');
            }
            // 检测验证码
            if (!self::check_vCode($phone, $vcode)) {
                return self::err('验证码错误');
            }
            if (User::isExist(['phone' => $phone], $user['id'])) {
                return self::err('手机号已存在');
            }
            $res = User::find($user['id'])->update(['phone' => $phone]);
            if ($res) {
                return self::ok();
            } else {
                return self::err('操作失败');
            }
        } else {
            return self::err('操作失败');
        }
    }

    /**
     * 获取验证码
     * @param Request $request
     * @return array
     */
    public function getVCode(Request $request)
    {
        $phone = $request->input('phone');
        $user = $request->getUser;
        if ($user) {
            if (!self::check_phone($phone)) {
                return self::err('手机号格式错误');
            }
            if (User::isExist(['phone' => $phone], $user['id'])) {
                return self::err('手机号已存在');
            }
            $code = self::code();
            $expiresAt = Carbon::now()->addMinutes(config('params')['sms']['cache_vcode_exp']);
            Cache::put('vcode_' . $phone, $code, $expiresAt);
            $cache = Cache::get('vcode_' . $phone);
            if ($cache) {
                // 发短信
                $sms = $this->sendSmsVCode($phone, $code);
                if ($sms) {
                    return self::ok();
                } else {
                    return self::err('获取验证码失败');
                }
            } else {
                return self::err('获取验证码失败');
            }
        } else {
            return self::err('操作失败');
        }
    }

    public function evaluate_list(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $evaluates = Evaluate::where(['customer_id' => $user['id'], 'status' => 1])->orderBy('id', 'desc')->get();
            return view('weChat.home.evaluate_list', [
                'evaluate_lists' => $evaluates,
                'title_name' => '评价列表',
            ]);
        } else {
            abort(404);
        }
    }

    public function vipCard(Request $request)
    {
        $app = Factory::payment($this->payment_config);
        $app_official = Factory::officialAccount($this->official_config);
        $user = $request->getUser;
        $get_user = User::find($user['id']);
        $total_fee = 36500;
        $is_buy_vip = false;
        if ($get_user) {
            if ($get_user->type == 0 && ($get_user->vip == 0 || $get_user->vip_exp_at < date('Y-m-d'))) {
                $is_buy_vip = true;
            }
            $trade_no = WeChat::generate18NumOrderNo($user['id']);
            $order = $app->order->unify([
                'body' => '年卡充值',
                'out_trade_no' => $trade_no,
                'total_fee' => $total_fee,
                'trade_type' => 'JSAPI',
                'openid' => $user['openid'],
                'notify_url' => url('wechat/payment/vipCardNotify')
            ]);
            if ($order['return_code'] == 'SUCCESS' && $order['result_code'] == 'SUCCESS') {
                $prepayId = $order['prepay_id'];
                $jssdk = $app->jssdk;
                $sdk = $jssdk->sdkConfig($prepayId);
                return view('weChat.ucenter.order_vip_card', [
                    'sdk' => $sdk,
                    'get_user' => $get_user,
                    'app' => $app_official,
                    'trade_no' => $trade_no,
                    'total_fee' => number_format($total_fee / 100, 2),
                    'title_name' => '购买年卡',
                    'is_buy_vip' => $is_buy_vip,
                ]);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function postVipCard(Request $request)
    {
        $trade_no = $request->input('trade_no');
        $price = $request->input('price');
        $recommend_no = trim($request->input('recommend_no'));
        $user = $request->getUser;
        $recommend_uid = null;
        if ($recommend_no) {
            $barber = User::where(['work_no' => $recommend_no])->first();
            $recommend_uid = $barber->id;
        }
        if ($user) {
            $data = [
                'user_id' => $user['id'],
                'recommend_uid' => $recommend_uid,
                'trade_no' => $trade_no,
                'price' => $price,
                'status' => 0,
            ];
            $app = Factory::payment(config('wechat.payment.default'));
            $wx_order = $app->order->queryByOutTradeNumber($trade_no);
            if ($wx_order['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($wx_order, 'result_code') === 'SUCCESS' && array_get($wx_order, 'trade_state') === 'SUCCESS') {
                    $data['status'] = 1;
                    User::find($user['id'])->update([
                        'vip' => 1,
                        'vip_exp_at' => Carbon::tomorrow()->addYear(),
                    ]);
                }
            }
            $res = VipCardLog::create($data);
            if ($res) {
                return self::ok();
            } else {
                return self::err('订单处理失败');
            }
        } else {
            return self::err('订单处理失败');
        }
    }

    public function barberWork(Request $request)
    {
        $status = $request->input('status');
        $mediaId = $request->input('media_id');
        $user = $request->getUser;
        if ($user) {
            $work_map = [
                'barber_id' => $user['id'],
            ];
            $get_work = WorkLog::where($work_map)->orderBy('updated_at', 'desc')->first();
            if ($get_work) {
                if ($status == 2 && $get_work['status'] == 0) {
                    return self::err('请先打上班卡');
                }
                $file_path = 'storage/work_img';
                $app = Factory::officialAccount($this->official_config);
                $stream = $app->media->get($mediaId);
                if (gettype($stream) == 'array') {
                    return self::err('操作失败');
                }
                $filename = $stream->save($file_path);
                $image_url = $file_path . '/' . $filename;

                $ntime = Carbon::now();
                if ($status == 2) {
                    // 下班
                    $save_data = [
                        'end_img' => $image_url,
                        'status' => 2,
                        'end_at' => $ntime,
                    ];
                } else {
                    // 下班
                    $save_data = [
                        'start_img' => $image_url,
                        'status' => 1,
                        'start_at' => $ntime,
                    ];
                }
                $res = WorkLog::find($get_work['id'])->update($save_data);
                if ($res) {
                    return self::ok();
                } else {
                    return self::err('操作失败');
                }
            } else {
                return self::err('请先关联门店');
            }
        } else {
            return self::err('操作失败');
        }
    }

}
