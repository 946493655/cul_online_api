<?php
namespace App\Models\Temp;

use App\Models\BaseModel as Model;

class BaseModel extends Model
{
    /**
     * 产品模板基础 model
     */

    //border边框类型：solid实线，dotted点线，dashed虚线，double双线，groove3D凹槽，ridge菱形边框，inset3D凹边，outset3D凸边，
    protected $border2names = [
        1=>'实线','点线','虚线','双线','3D凹槽','菱形边框','3D凹边','3D凸边',
    ];
    protected $border2s = [
        1=>'solid','dotted','dashed','double','groove','ridge','inset','outset',
    ];

    //文字大小（单位px）：
//    protected $fontsizes = [
//        1=>12,14,16,18,20,22,24,26,30,
//    ];
    //字体：
}