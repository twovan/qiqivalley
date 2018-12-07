<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialDetail extends Model
{

    protected $table = 'material_details';

    protected $fillable = [
        'id',
        'courses_id',
        'material_id',
        'num',
        'created_ts'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id','id');
    }



}
