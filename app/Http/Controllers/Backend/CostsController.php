<?php

namespace App\Http\Controllers\Backend;


use App\Models\Store;
use App\Models\User;
use App\Models\Admin;
use App\Models\Cost;
use App\Models\CostDetail;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CostsController extends BaseController
{
    // 消费信息展示
    public function index(Request $request)
    {

        $data = [];
        $post_flag = $_POST;

        $defult_result = [];
        $post_data = [];

        //没有提交显示默认
        if (empty($post_flag)) {
            $flag = 0;
            $defult_result = Cost::with('user', 'store', 'admin', 'details')->orderBy('id', 'desc')
                ->paginate(config('params')['pageSize']);
            //dd($defult_result->toArray());


        } else {
            $flag = 1;
            $request_name = $request->get('b_name');
            $request_phone = $request->get('b_tel');
            $users = new User();

            //查询用户或手机号码
            if (!empty($request_name)) {
                $post_data = $users->where('name', $request_name)->first();
            } else {
                $post_data = $users->where('phone', $request_phone)->first();
            }


            //没有查到信息返回为空
            if (collect($post_data)->isEmpty()) {
                $data = [];
            } else {
                //查到信息,再查消费信息
                $user_id = $users['id'];
                $cost_result = Cost::where('user_id', $user_id)->with('user', 'store', 'admin', 'details')->get();
                //如果消费信息为空,只显示用户信息
                if (collect($cost_result)->isEmpty()) {
                    $data['user'] = $post_data;
                    $data['cost'] = [];
                } else {
                    $data['user'] = $post_data;
                    $data['cost'] = $cost_result;
                }
            }

        }

        //通过服务信息
        $service_arr = [];
        $services = Service::get();
        if (collect($services)->isNotEmpty()) {
            $services = $services->toArray();
            foreach ($services as $val) {
                $service_arr[$val['id']] = $val;
            }
        }

        return view('backend.costs.index', [
            'flag' => $flag,
            'default_lists' => $defult_result,
            'list' => $data,
            'service_arr' => $service_arr,
            'list_title_name' => '消费信息',
            'request_params' => $request,
        ]);

    }

    // 消费保存
    public function saveCost(Request $request)
    {
        $params = $request->json()->all();
        if (empty($params)) {
           return  self::err();
        }

        $user_id = $params['user_id'];
        if(empty($user_id)){
            return self::err('用户id不能不空');
        }

        $users = User::find($user_id);
        $balance = $users->balance;
        $ticket = $users->ticket;

        if($balance<$params['money_count']){
            return self::err('用户余额不足，请充值!');
        }

        if($ticket<$params['ticket_count']){
            return self::err('用户门票不足,请充值!');
        }
        //dd($params);
        $cost_data = [
            'user_id' => $params['user_id'],
            'last_ticket' => $params['last_ticket'],
            'last_balance' => $params['last_balance'],
            'amount' => $params['money_count']??0,
            'ticket_num' => $params['ticket_count']??0,
            'admin_id' => Auth::guard('admin')->id(),
            'cost_ts' => date('Y-m-d H:i:s'),
            'store_id'=>$params['store_id'],
        ];
        $costs= Cost::create($cost_data);
        if(!$costs){
            return self::err('插入数据失败，请稍后...');
        }
        $cost_id = $costs->id;
        $users->balance = bcsub($balance,$cost_data['amount']);
        $users->ticket = bcsub($ticket,$cost_data['ticket_num']);

        if(!$users->update()){
            return  self::err('系统错误，更新用户余额失败...');
        }

        if (!empty($params['details'])) {
            foreach ($params['details'] as $details) {
                $detail_data = [
                    'user_id' => $params['user_id'],
                    'cost_id' => $cost_id,
                    'service_id' => $details['service_id'],
                    'service_num' => $details['service_num'],
                    'ticket_num' => $details['ticket_num'],
                    'cost_type' => $details['cost_type'],
                ];
                $d_result = CostDetail::create($detail_data);
                if(!$d_result){
                    return self::err('系统错误，消费记录插入失败,请稍后...');
                }
            }
        }

        //插入杂项
        if (!empty($params['sundry'])) {
            foreach ($params['sundry'] as $sundrys) {
                $sundrydata = [
                    'user_id' => $params['user_id'],
                    'cost_id' => $cost_id,
                    'ticket_num' => $sundrys['ticket_num'],
                    'sundry_name' => $sundrys['sundry_name'],
                    'sundry_num' => $sundrys['sundry_num'],
                    'cost_type' => $sundrys['cost_type'],
                ];
                $s_result = CostDetail::create($sundrydata);
                if(!$sundrydata){
                    return  self::err();
                }
            }

        }

        return self::ok();
    }

}
