<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kids extends Model
{

    protected $table = 'kids';

    protected $fillable = [
        'id',
        'p_id',
        'name',
        'sex',
        'DOB',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'p_id','id');
    }

}
