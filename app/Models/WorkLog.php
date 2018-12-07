<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{

    protected $table = 'work_logs';

    protected $fillable = [
        'barber_id',
        'store_id',
        'start_at',
        'end_at',
        'start_img',
        'end_img',
        'status',
    ];

    public function barber(){
        return $this->belongsTo(User::class, 'barber_id', 'id');
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

}
