<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'order_no',
        'queue_no',
        'customer_id',
        'barber_id',
        'store_id',
        'service_id',
        'pay_type',
        'finished_at',
        'pay_at',
        'pay_fee',
        'img_url',
        'status',
    ];

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function barber(){
        return $this->belongsTo(User::class, 'barber_id', 'id');
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }



}
