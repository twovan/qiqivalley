<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{

    protected $table = 'materials';

    protected $fillable = [
        'id',
        'material_name',
        'remark',
        'created_at',
        'updated_at'

    ];

    public function details()
    {
        return $this->hasMany(MaterialDetail::class,'material_id','id');
    }


}
