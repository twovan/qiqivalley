<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HairStyle extends Model
{

    protected $table = 'hair_styles';

    protected $fillable = [
        'name',
        'hair_type',
        'upload_id',
        'upload_url',
        'status',
    ];

}
