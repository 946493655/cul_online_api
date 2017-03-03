<?php
namespace App\Models\Product;

use App\Models\ProductModel;

class LayerModel extends BaseModel
{
    protected $table = 'pro_layer';
    protected $fillable = [
        'id','name','a_name','pro_id','tl_id','timelong','delay','con','attr','isshow','created_at','updated_at',
    ];

    //动画名称a_name，系统自动添加，layer_+用户id_+产品id_+10000随机值
    //属性attr：bigbg，width，height，isborder，border1，border2，border3，isbg，bg，iscolor，color，fontsize，
    //内容con：iscon，text，img，
    //是否显示isshow：1显示，2不显示

//    //速度曲线
//    protected $funcs = [
//        1=>'linear','ease','ease-in','ease-out','ease-in-out',/*'cubic-bezier',*/
//    ];
//    protected $funcNames = [
//        1=>'慢-快-慢，默认','匀速','低速开始','低速结束','低速开始和结束',/*'贝塞尔函数自定义',*/
//    ];

    /**
     * 获得产品名称
     */
    public function getProductName()
    {
        $productModel = ProductModel::find($this->pro_id);
        return $productModel ? $productModel->name : '';
    }

    /**
     * 动画内容
     */
    public function getCons()
    {
        return $this->con ? unserialize($this->con) : [];
    }

    /**
     * 动画属性
     */
    public function getAttrs()
    {
        return $this->attr ? unserialize($this->attr) : [];
    }

    /**
     * 旗下的关键帧
     */
    public function getFrames($attr)
    {
        $models = FrameModel::where('layerid',$this->id)
            ->where('pro_id',$this->pro_id)
            ->where('attr',$attr)
            ->get();
        return count($models) ? $models : [];
    }
}