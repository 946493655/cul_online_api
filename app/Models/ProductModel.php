<?php
namespace App\Models;

class ProductModel extends BaseModel
{
    /**
     * 用户产品
     */

    protected $table = 'product';
    protected $fillable = [
        'id','name','tempid','uid','cate','uname','intro','thumb','linkType','link','attr','isshow','created_at','updated_at',
    ];
}