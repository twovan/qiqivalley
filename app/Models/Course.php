<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $table = 'courses';

    protected $fillable = [
        'id',
        'user_id',
        'courses_name',
        'courses_ts',
        'courses_num',
        'remark',
        'created_at'

    ];

    //查询用户
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    //查询耗材
    public function materialdetail()
    {
        return $this->hasMany(MaterialDetail::class,'courses_id','id');
    }
}
