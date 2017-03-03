<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $limit = 20;      //每页显示记录数
    protected $selfModel;       //当前控制器model

    public function __construct()
    {
    }

    /**
     * 对象转为数组
     */
    public function objToArr($obj)
    {
        return json_decode(json_encode($obj),true);
    }
}
