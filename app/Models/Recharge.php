<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{

    protected $table = 'recharges';

    protected $fillable = [
        'id',
        'user_id',
        'last_ticket',
        'last_balance',
        'amount',
        'ticket_num',
        'admin_id',
        'recharge_ts',
        'created_at',
        'store_id',

    ];

    //用户关联
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    //操作员关联
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id','id');
    }

    //店铺关联
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

}
