<?php

namespace App\Http\Controllers\Backend;

use App\Models\Recharge;
use App\Models\Store;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RechargesController extends BaseController
{

    // 充值信息
    public function index(Request $request)
    {

        $data =[];
        $request_name = $request->get('b_name');
        $request_phone = $request->get('b_tel');
        $users = new User();
        if(!empty($request_name)){
            $users = $users->where('name', 'like', '%' . $request_name . '%');
        }

        if(!empty($request_phone)){
            $users = $users->where('phone', 'like', '%' . $request_phone . '%');
        }

        $users= $users->get();
        if(collect($users)->isNotEmpty()){
            $ids = collect($users)->pluck('id')->all();
        }

        if(!empty($ids)){
            $data = Recharge::whereIn('user_id',$ids)->with('user','store', 'admin')
                ->orderBy('id', 'desc')
                ->paginate(config('params')['pageSize']);
        }


        return view('backend.recharges.index', [
            'lists' => $data,
            'list_title_name' => '充值信息',
            'request_params' => $request,
        ]);

    }


    //保存
    public function save(Request $request)
    {
        $id = $request->input('id');
        $id = null;
        //dd($id);

        $request_all = $request->all();
        $admin_id = $admin_id = Auth::guard('admin')->id();
        //dd($request_all['user_id']);
        $data = [
            'user_id' => $request_all['user_id'],
            'last_ticket' => $request_all['last_ticket'],
            'last_balance' => $request_all['last_balance'],
            'amount' => $request_all['amount'],
            'ticket_num' => $request_all['ticket_num'],
            'admin_id' => $admin_id,
            'store_id'=>$request_all['store_id'],
            'recharge_ts' => date('Y-m-d H:i:s'),
        ];

        if (empty($id)) {
          return $this->rechargesAdd($data);
        }

    }


    protected function  rechargesAdd($data){

        try {

            if (Recharge::create($data)) {
                $user = User::find($data['user_id']);
                //先加再重新赋值
                $blance = bcadd ($user->balance,$data['amount']);
                $ticket = bcadd ($user->ticket,$data['ticket_num']);
                $user->balance = $blance;
                $user->ticket = $ticket;
                if($user->update()){
                    return self::ok();
                }
            }
        } catch (\Exception $ex) {
            //echo $ex->getMessage();
            return self::err();
        }
    }


}
