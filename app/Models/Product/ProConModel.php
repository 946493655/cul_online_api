<?php
namespace App\Models\Product;

class ProConModel extends BaseModel
{
    /**
     * 产品动画的图片文字管理
     */

//    protected $table = 'bs_pro_con';
    protected $table = 'pro_con';
    protected $fillable = [
        'id','productid','layerid','genre','pic_id','name','record','sort','isshow','created_at','updated_at',
    ];
    protected $genres = [
        1=>'图片','文字'
    ];

    /**
     * 动画设置信息
     */
    public function getLayer()
    {
        return ProLayerModel::find($this->layerid);
    }

    /**
     * 动画设置名称
     */
    public function getlayerName()
    {
        $layerModel = $this->getLayer();
        return $layerModel ? $layerModel->name : '';
    }

    public function getName()
    {
        if ($this->genre==1) {
            $name = $this->getPicName();
        } elseif ($this->genre==2) {
            $name = $this->name;
        }
        return $name;
    }

    public function getGenreName()
    {
        return array_key_exists($this->genre,$this->genres) ? $this->genres[$this->genre] : '';
    }

    public function getPicName()
    {
        return $this->pic($this->pic_id) ? $this->pic($this->pic_id)->name : '';
    }

    public function getPicUrl()
    {
        return $this->getPic($this->pic_id) ? $this->getPic($this->pic_id) : '';
    }

    /**
     * 获得属性样式名称
     */
    public function getAttrName()
    {
        $attrModel = ProAttrModel::where('layerid',$this->layerid)->first();
        return $attrModel ? $attrModel->style_name : '';
    }
}