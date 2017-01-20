<?php
namespace App\Models;

class TempProModel extends BaseModel
{
    /**
     * 创作模板 model
     */

    protected $table = 'temp_pro';
    protected $fillable = [
        'id','name','serial','cate','intro','thumb','linkType','link','isshow','created_at','updated_at',
    ];
    //serial序列号：AE_ + 年月日时分秒 + 10000的随机值
}