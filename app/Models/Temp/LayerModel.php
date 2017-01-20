<?php
namespace App\Models\Temp;

class LayerModel extends BaseModel
{
    /**
     * 模板的动画设置
     */

    protected $table = 'temp_layer';
    protected $fillable = [
        'id','name','tempid','a_name','delay','timelong','con','attr','created_at','updated_at',
    ];

    //动画名称a_name：系统自动添加，layer_ + 模板id_ + 10000的随机数

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
}