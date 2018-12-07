<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VipCardLog extends Model
{

    protected $table = 'vip_card_logs';

    protected $fillable = [
        'user_id',
        'recommend_uid',
        'trade_no',
        'price',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
