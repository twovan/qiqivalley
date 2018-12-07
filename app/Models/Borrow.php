<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{

    protected $table = 'borrows';

    protected $fillable = [
        'id',
        'b_name',
        'user_id',
        'borrow_ts',
        'back_ts',
        'store_id',
        'admin_id',

    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id','id');
    }

}
