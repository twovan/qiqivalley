<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $user = null;

    public function __construct(){
        $this->middleware('weChatLogin');
    }

}
