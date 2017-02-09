<?php
namespace App\Models\Product;

class FrameModel extends BaseModel
{
    /**
     * 模板的关键帧
     */

    protected $table = 'pro_frame';
    protected $fillable = [
        'id','pro_id','layerid','tf_id','attr','per','val','created_at','updated_at',
    ];

    //key动画的属性名：
    protected $attrs = [
        1=>'left','top','opacity','rotate','scale',
    ];
    protected $attrNames = [
        1=>'水平距离','垂直距离','透明度','旋转','缩放',
    ];

    public function getLayerName()
    {
        $layer = LayerModel::find($this->layerid);
        return $layer ? $layer->name : '';
    }

    public function getAttr()
    {
        return array_key_exists($this->attr,$this->attrs) ? $this->attrs[$this->attr] : '';
    }

    public function getAttrName()
    {
        return array_key_exists($this->attr, $this->attrNames) ? $this->attrNames[$this->attr] : '';
    }
}