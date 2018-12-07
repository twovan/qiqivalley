<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Evaluate as TM;
use App\Models\Order;
use Illuminate\Http\Request;

class EvaluateController extends BaseController
{

    public function create($id, Request $request)
    {
        $user = $request->getUser;
//        $user = User::find(2);
        if ($user){
            $map = [
                'status' => 2,
                'customer_id' => $user['id'],
                'id' => $id,
            ];
            $order = Order::where($map)->first();
            if ($order){
                return view('weChat.evaluate.create', [
                    'order' => $order,
                    'title_name' => '订单评价',
                ]);
            }else{
                abort(404);
            }
        }else{
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $user = $request->getUser;
        $request_all = $request->all();
        if ($user){
            $map = [
                'order_id' => $request_all['order_id'],
            ];
            $order = TM::where($map)->first();
            if ($order){
                return self::err('已评论过');
            }
            if (isset($request_all['content'])){
                if (mb_strlen($request_all['content']) > 30){
                    return self::err('评论内容不得超过30个字符');
                }
            }
            $request_all['status'] = 1;
            // todo 加事务
            $res = TM::create($request_all);
            if ($res){
                Order::find($request_all['order_id'])->update(['status' => 3]);
                return self::ok();
            }else{
                return self::err('操作失败');
            }
        }else{
            return self::err('操作失败');
        }
    }

}
