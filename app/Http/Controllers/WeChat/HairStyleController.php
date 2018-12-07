<?php

namespace App\Http\Controllers\WeChat;

use App\Models\HairStyle as TM;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WeChat;
use EasyWeChat\Factory;

class HairStyleController extends BaseController
{


    public function index(Request $request)
    {
        $user = $request->getUser;
        $type = $request->input('type');
        $isworker = false;
        if ($user) {
            $res = User::find($user['id']);
            if (!$type) {
                $type = 1;
            }

            $map = [
                'status' => 1,
                'hair_type' => $type,

            ];

            $data = TM::where($map)->orderBy('id', 'desc')->get();
            return view('weChat.home.hairstyle_list', [
                'lists' => $data,
                'type' => $type,
                'title_name' => '图书精选',
                'isworker' => $isworker
            ]);
        }
    }
}
