<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{
    //公共模板页
    public function index(Request $request){
        return view('index.layout.index',[
            'user' => $request->getUser,
        ]);
    }

    //首页
    public function base(Request $request){
        return view('index.layout.base',[
        'user' => $request->getUser,
        ]);
    }

}
