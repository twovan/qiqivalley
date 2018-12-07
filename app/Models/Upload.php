<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{

    protected $table = 'uploads';

    protected $fillable = [
        'name',
        'disk',
        'path',
        'size',
        'mime_type',
    ];

}
