<?php

namespace App\Http\Controllers\Index;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index(Request $request){
        $request_order_no = $request->get('order_no');
        $user = $request->getUser;
        if ($user){
            $map = [
                'customer_id' => $user['id'],
            ];
            $map[] = ['status', '>', 0];
            if($request_order_no){
                $map['order_no'] = $request_order_no;
            }
            $data = Order::where($map)->orderBy('id','desc')->paginate(config('params')['pageSize']);

            return view('index.order.index', [
                'lists' => $data,
                'list_title_name' => '订单',
                'request_params' => $request,
            ]);
        }else{
            abort(404);
        }
    }

    public function image($id, Request $request){
        $user = $request->getUser;
        if ($user){
            $map = [
                'customer_id' => $user['id'],
                'id' => $id,
            ];
            $map[] = ['status', '>', 0];
            $data = Order::where($map)->orderBy('id','desc')->first();
            if ($data){
                return view('index.order.image', [
                    'list' => $data,
                    'list_title_name' => '图片上传',
                ]);
            }
        }
        abort(404);
    }


    public function uploadImage(Request $request)
    {
        $user = $request->getUser;
        if ($user) {
            $info = $request->file('file');
            $save_path = 'order_img';
            $id = $request->input('order_id');
            $map = [
                'customer_id' => $user['id'],
                'id' => $id,
            ];
            $map[] = ['status', '>', 1];
            $order = Order::where($map)->first();
            if ($order) {
                $filenames = [];
                foreach ($info as $key => $value){
                    if(!empty($value)){
                        $filenames[] = $value->store($save_path, 'public');

                    }
                }
                $file_path = storage_path().'/app/public/';
            // print_r($filenames);exit;
                $save_data = false;
                if (count($filenames)) {
                    if ($order->img_url) {
                        $olds = unserialize($order->img_url);
                         if (gettype($olds) == 'array'){
                            foreach ($olds as $_old) {
                                if (file_exists($file_path.$_old)) {
                                    unlink($file_path.$_old);
                                    // echo $file_path.$_old ;exit;
                                }
                            }
                         }else{
                            if (file_exists($file_path.$_olds)) {
                                unlink($file_path.$olds);
                            }
                         }
                    }
	               $save_name = serialize($filenames);


        //             else {
        //                 $order_img = unserialize($order->img_url);
        //                 if (gettype($order_img) != 'array') {
        //                     $order_img = [$order_img];
        //                 }
        //                 $order_img = array_merge($order_img, $filenames);
        //                 if (count($order_img) <= 6){
        //                     $save_name = serialize($order_img);
        //                 }else{
        //                     //return $this->err('图片上传过多');
							 // abort(500);
        //                 }
        //             }
                    $save_data = [
                        'img_url' => $save_name,
                    ];
                   
                }
                if ($save_data) {
                    $res = Order::find($id)->update($save_data);
                    if ($res) {
                        return $this->ok();
                    }
                }
                                
            }
        }
        abort(500);
    }

    // public function uploadImage(Request $request)
    // {
    //     $user = $request->getUser;
    //     if ($user) {
    //         $info = $request->file('file');
    //         $save_path = 'order_img';
    //         $id = $request->input('order_id');
    //         $map = [
    //             'customer_id' => $user['id'],
    //             'id' => $id,
    //         ];
    //         $map[] = ['status', '>', 1];
    //         $order = Order::where($map)->first();
    //         if ($order) {

    //             // $filename = $info->store($save_path, 'public');
    //             // if ($filename) {
    //             //     if (empty($order->img_url)) {
    //             //         $save_name = serialize([$filename]);
    //             //     } else {
    //             //         $order_img = unserialize($order->img_url);
    //             //         if (count($order_img) < 5){
    //             //             if (gettype($order_img) == 'array') {
    //             //                 $save_name = serialize(array_merge($order_img, [$filename]));
    //             //             } else {
    //             //                 $save_name = serialize([$order_img, $filename]);
    //             //             }
    //             //         }else{
    //             //             abort(500);
    //             //         }
    //             //     }
    //             //     $save_data = [
    //             //         'img_url' => $save_name,
    //             //     ];
    //             //     $res = Order::find($id)->update($save_data);
    //             //     if ($res) {
    //             //         return $this->ok();
    //             //     }
    //             // }




    //                             foreach ($info as $key => $value){
    //                                          if(!empty($value)){
    //                                                 $filename = $value->store($save_path, 'public');
    //                                                 if ($filename) {
    //                                                     if (empty($order->img_url)) {
    //                                                         $save_name = serialize([$filename]);
    //                                                     } else {
    //                                                         $order_img = unserialize($order->img_url);
    //                                                         if (count($order_img) < 5){
    //                                                             if (gettype($order_img) == 'array') {
    //                                                                 $save_name = serialize(array_merge($order_img, [$filename]));
    //                                                             } else {
    //                                                                 $save_name = serialize([$order_img, $filename]);
    //                                                             }
    //                                                         }else{
    //                                                             abort(500);
    //                                                         }
    //                                                     }
    //                                                     $save_data = [
    //                                                         'img_url' => $save_name,
    //                                                     ];
                                                       
    //                                                 }
                                            
    //                                          }
    //                                         }
    //                                          $res = Order::find($id)->update($save_data);
    //                                         if ($res) {
    //                                             return $this->ok();
    //                                         }
    //         }
    //     }
    //     abort(500);
    // }
}
