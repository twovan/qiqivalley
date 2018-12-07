<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{

    protected $table = 'evaluates';

    protected $fillable = [
        'order_id',
        'customer_id',
        'store_id',
        'barber_id',
        'star',
        'content',
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

    public function order(){
        return $this->belongsTo(Order::class);
    }

}
