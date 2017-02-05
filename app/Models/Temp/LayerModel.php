<?php
namespace App\Models\Temp;

class LayerModel extends BaseModel
{
    /**
     * 模板的动画设置
     */

    protected $table = 'temp_layer';
    protected $fillable = [
        'id','name','tempid','a_name','delay','timelong','con','attr','isshow','created_at','updated_at',
    ];

    //动画名称a_name：系统自动添加，layer_ + 模板id_ + 10000的随机数
    //属性attr：width，height，isborder，border1，border2，border3，isbg，bg，iscolor，color，fontsize，bigbg，
    //内容con：iscon，text，img，
    //是否显示isshow：1小时，2不显示

    /**
     * 旗下的关键帧
     */
    public function getFrames($attr)
    {
        $models = FrameModel::where('layerid',$this->id)
            ->where('tempid',$this->tempid)
            ->where('attr',$attr)
            ->get();
        return count($models) ? $models : [];
    }

    /**
     * 获取模板名称
     */
    public function getTempName()
    {
        $tempModel = LayerModel::find($this->tempid);
        return $tempModel ? $tempModel->name : '';
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
}