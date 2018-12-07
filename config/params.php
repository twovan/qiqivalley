<?php

return [

    /*
    |--------------------------------------------------------------------------
    | params
    |--------------------------------------------------------------------------
    |
    */
    // 每页显示条数
    'pageSize' => 20,

    // 状态
    'status' => [
        1 => '启用',
        0 => '禁用',
    ],

    'userVip' => [
        0 => '普通用户',
        1 => '会员',
    ],

    'userType' => [
        0 => '消费者',
        1 => '在职人员',
    ],

    'evaluateStar' => [
        1 => '1星',
        2 => '2星',
        3 => '3星',
        4 => '4星',
        5 => '5星',
    ],

//    'gender' => [
//        0 => '女士',
//        1 => '男士',
//    ],

    'uploadImg' => [
        'size' => 2, //上传图片大小，2M
//        'mimeType' => ['image/jpeg'],
    ],

    'pay_type' => [
        'wxPay' => '微信支付',
        'yearCard' => '年卡支付',
    ],

    // 书籍类别
    'hair_type' => [
        1 => '百科',
        2 => '历史',
        3 => '育儿',
        4 => '艺术',
        5 => '英语',
        6 => '益智',
        7 => '故事',
    ],

    // 订单状态
    'order_status' => [
        -1 => '未支付',
        1 => '待服务',
        2 => '待评价',
        3 => '已完成',
        4 => '已取消',
    ],

    // VIP类型
    'vip_type' => [
        0 => '普通用户',
        1 => '终身会员',
        2 => '月卡会员',
        3 => '年卡会员',
        4 => '次卡会员',
        5 => '充值会员',
    ],

    // 短信
    'sms' => [
        // HTTP 请求的超时时间（秒）
        'timeout' => 5.0,

        // 默认发送配置
        'default' => [
            // 网关调用策略，默认：顺序调用
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

            // 默认可用的发送网关
            'gateways' => [
                'yuntongxun',
            ],
        ],
        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => '/tmp/easy-sms.log',
            ],
            'yuntongxun' => [
                'app_id' => env('YTX_APPID'),
                'account_sid' => env('YTX_SID'),
                'account_token' => env('YTX_TOKEN'),
                'is_sub_account' => false,
            ],
        ],
        'vcode_template_id' => '333214',
        // 短信验证码有效期
        'cache_vcode_exp' => 10, // 10分钟
    ],

];
