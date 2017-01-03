<?php
namespace App\Models;

class TempProModel extends BaseModel
{
    /**
     * 创作模板 model
     */

    protected $table = 'temp_pro';
    protected $fillable = [
        'id','name','cate','intro','thumb','linkType','link','created_at','updated_at',
    ];
}