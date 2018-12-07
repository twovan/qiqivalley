<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Evaluate;
use App\Models\Service;
use App\Models\Store as TM;
use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\WeChat;

class StoreController extends BaseController
{

    public function __construct(){
        parent::__construct();
        $this->official_config = config('wechat.official_account.default');
        $this->payment_config = config('wechat.payment.default');
    }

    public function index(Request $request)
    {
        $map = [
            'status' => 1,
        ];

        //增加判断
        $user = $request->getUser;
        $iswork=false;
        if ($user) {
            $res = User::find($user['id']);
            if ($res['type'] == 1) {
                // 员工
                $iswork=true;
                $work_map = [
                    'barber_id' => $user['id'],
                ];
                $get_work = WorkLog::where($work_map)->orderBy('updated_at','desc')->first();
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
                    'isworker' => $iswork,
                ]);
            } else {
                // 用户
                $data = TM::where($map)->orderBy('id', 'desc')->get();
                return view('weChat.home.index', [
                    'lists' => $data,
                    'isworker' => $iswork,
                    'title_name' => '首页',
                ]);
            }
        } else {
            abort(404);
        }


    }

    public function info($id, Request $request)
    {
        $user = $request->getUser;
        $work_hard = $request->input('work_hard');
        if ($user) {
            $get_user = User::find($user['id']);
            if ($get_user['type'] == 1) {
                // 员工添加上班记录
                // 已经记录过
                $work_map2 = [
                    'barber_id' => $user['id'],
                    'store_id' => $id,
                ];
                $get_work2_ok = false;
                $get_work2 = WorkLog::where($work_map2)->orderBy('updated_at', 'asc')->first();
                if ($get_work2) {
                    if ($get_work2->status < 2) {
                        $get_work2_ok = true;
                    }
                }

                //员工已经打过卡
                $work_map3 = [
                    'barber_id' => $user['id'],
                    'status' => 1,
                ];

                // 员工打卡了但没扫码有记录
                $work_map4 = [
                    'barber_id' => $user['id'],
                    'status' => 0,
                ];

                $get_work3 = WorkLog::where($work_map3)->orderBy('updated_at', 'asc')->first();
                $get_work4 = WorkLog::where($work_map4)->orderBy('updated_at', 'asc')->first();

                if ($get_work2_ok === false && empty($get_work3) && $work_hard == 1 && $get_work4 == null) {
                    $work_data = [
                        'barber_id' => $user['id'],
                        'store_id' => $id,
                        'status' => 0,
                    ];
                    WorkLog::create($work_data);
                } elseif ($get_work2_ok === false && empty($get_work3) && $work_hard == 1 && $get_work4 != null) {
                    //如果已存在就更新时间 2018/8/11
                    WorkLog::where(['barber_id' => $user['id'], 'status' => 0])->update(['updated_at' => Carbon::now(), 'store_id' => $id]);
                }
                // 改需求：员工扫码跳个人中心
                if ($work_hard == 1) {
                    return redirect('wechat/user');
                }
            }
            $map = [
                'status' => 1,
                'id' => $id,
            ];
            $data = TM::where($map)->first();
            if ($data) {
                $services = Service::where(['store_id' => $id, 'status' => 1])->orderBy('id', 'desc')->get();
                $evaluates = Evaluate::where(['store_id' => $id, 'status' => 1])->orderBy('id', 'desc')->limit(5)->get();
                return view('weChat.home.store_info', [
                    'list' => $data,
                    'service_lists' => $services,
                    'evaluate_lists' => $evaluates,
                    'title_name' => '门店详情',
                    'get_user' => $get_user,
                ]);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function evaluate_list($id, Request $request)
    {
        if ($id) {
            $evaluates = Evaluate::where(['store_id' => $id, 'status' => 1])->orderBy('id', 'desc')->get();
            return view('weChat.home.evaluate_list', [
                'evaluate_lists' => $evaluates,
                'title_name' => '评价列表',
            ]);
        } else {
            abort(404);
        }
    }


}
