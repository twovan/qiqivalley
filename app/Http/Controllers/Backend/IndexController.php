<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    //公共模板页
    public function index(Request $request){
        return view('backend.layout.index',[
            'user' => $request->getUser,
        ]);
    }

    //首页
    public function base(Request $request){
        return view('backend.layout.base',[
            'user' => $request->getUser,
        ]);
    }

}
