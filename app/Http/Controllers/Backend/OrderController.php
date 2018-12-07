<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order as ThisModel;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index(Request $request){
        $request_order_no = $request->get('order_no');
        $request_store = $request->get('store');
        $request_barber_phone = $request->get('barber_phone');
        $request_customer_phone = $request->get('customer_phone');
        $request_stime = $request->get('stime');
        $request_etime = $request->get('etime');
        $where = [];
        if($request_order_no){
            $where['order_no'] = $request_order_no;
        }
        if($request_stime){
            $where[] = ['finished_at','>=',$request_stime];
        }
        if($request_etime){
            $where[] = ['finished_at','<=',$request_etime];
        }
        if ($request_barber_phone){
            $barber_id = User::where('phone',$request_barber_phone)->value('id');
            $where['barber_id'] = $barber_id;
        }
        if ($request_customer_phone){
            $customer_id = User::where('phone',$request_customer_phone)->value('id');
            $where['customer_id'] = $customer_id;
        }
        if ($request_store){
            $store_ids = Store::where([['name', 'like', '%' . $request_store . '%']])->pluck('id')->toArray();
            $data = ThisModel::where($where)->whereIn('store_id', $store_ids)->orderBy('id','desc')->paginate(config('params')['pageSize']);
        }else{
            $data = ThisModel::where($where)->orderBy('id','desc')->paginate(config('params')['pageSize']);
        }

        return view('backend.order.index', [
            'lists' => $data,
            'list_title_name' => '订单',
            'request_params' => $request,
        ]);
    }

    public function save(Request $request){
        $id = $request->input('id');
        $request_all = $request->all();
        $res = ThisModel::find($id)->update($request_all);
        if($res){
            return $this->ok();
        }else{
            return $this->err('失败');
        }
    }
}
