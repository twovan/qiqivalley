<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $table = 'services';

    protected $fillable = [
        'store_id',
        'name',
        'price',
        'ticket_num',
        'status',
        'remark',
        'upload_id',
        'upload_url',
    ];

    /**
     * 查询是否存在
     * @param $field
     * @param null $id
     * @return bool
     */
    public static function isExist($field, $id = null){
        $data = self::where($field)->first();
        if ($data){
            if ($id){
                if ($id != $data->id){
                    return true;
                }
            }else{
                return true;
            }
        }
        return false;
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

}
