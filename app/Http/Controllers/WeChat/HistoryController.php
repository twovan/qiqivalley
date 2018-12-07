<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Borrow;
use App\Models\User;
use App\Models\Cost;
use App\Models\CostDetail;
use App\Models\Recharge;
use arbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use EasyWeChat\Factory;

class HistoryController extends BaseController
{
    protected $official_config;
    protected $payment_config;

    public function __construct()
    {
        parent::__construct();
        $this->official_config = config('wechat.official_account.default');
        $this->payment_config = config('wechat.payment.default');
    }



    //查看充值记录
    public function getRechargesList(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $res = Recharge::where('user_id', $user['id'])->with('user','admin','store')->get();
            //dd($res);
            //$res = User::find($user['id']);
            return view('weChat.history.recharges_list', [
                'list' => $res,
                'title_name' => '查看充值记录',
            ]);
        } else {
            abort(404);
        }
    }

    //查看消费记录
    public function getCostsList(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $res =  Cost::where('user_id', $user['id'])->with('user','details','store')->get();
            return view('weChat.history.costs_list', [
                'lists' => $res,
                'title_name' => '查看消费记录',
            ]);
        } else {
            abort(404);
        }
    }

    //查看借阅记录
    public function getBorrowsList(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            //$res = User::find($user['id']);
            $res =  Borrow::where('user_id', $user['id'])->with('user','admin','store')->get();
            return view('weChat.history.borrows_list', [
                'list' => $res,
                'title_name' => '查看借阅记录',
            ]);
        } else {
            abort(404);
        }
    }






}
