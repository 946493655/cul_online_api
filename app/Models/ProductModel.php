<?php
namespace App\Models;

class ProductModel extends BaseModel
{
    protected $table = 'products';
    protected $fillable = [
        'id','name','serial','cate','uid','uname','intro','thumb','linkType','link','pid','isauth','istop','sort','isshow','created_at','updated_at',
    ];
    //视频链接类型：1Flash代码，2html代码，3通用代码，4其他网址链接
    protected $linkTypes = [
        1=>'flash代码','html代码','通用代码','其他视频网址',
    ];
    protected $isauths = [
        1=>'未审核','未通过审核','通过审核',
    ];
    protected $istops = [
        '不置顶','置顶',
    ];
    protected $isshows = [
        1=>'不显示','显示',
    ];

    public function getCate()
    {
        return array_key_exists($this->cate,$this->cates2) ? $this->cates2[$this->cate] : '';
    }

    public function isauth()
    {
        return array_key_exists($this->isauth,$this->isauths) ? $this->isauths[$this->isauth] : '';
    }

    public function istop()
    {
        return array_key_exists($this->istop,$this->istops) ? $this->istops[$this->istop] : '';
    }

    public function isshow()
    {
        return array_key_exists($this->isshow,$this->isshows) ? $this->isshows[$this->isshow] : '';
    }

    public function linkType()
    {
        return array_key_exists($this->linkType,$this->linkTypes) ? $this->linkTypes[$this->linkType] : '';
    }

    /**
     * 获取该产品的属性
     */
    public function getAttrs()
    {
        $attrModels = ProductAttrModel::where('productid',$this->id)->get();
        return count($attrModels) ? $attrModels : [];
    }

    /**
     * 得到修改过的产品的动画设置
     */
    public function getProLayers()
    {
        $layerModels = ProductLayerModel::where('productid',$this->id)->get();
        foreach ($layerModels as $layerModel) {
            if ($layerModel->record && $records=unserialize($layerModel->record)) {
                if ($records['delay'] || $records['timelong'] || $records['func']) {
                    $layerRecord[$layerModel->id] = $layerModel;
                }
            }
            if ($layerModel->is_add) {
                $layerAdd[$layerModel->id] = $layerModel;
            }
        }
        return array(
            'records'=> isset($layerRecord)?$layerRecord:[],
            'adds'=> isset($layerAdd)?$layerAdd:[],
        );
    }

    /**
     * 得到修改过的产品的样式
     */
    public function getProAttrs()
    {
        foreach ($this->getAttrs() as $attr) {
            if ($attr->record && $records=unserialize($attr->record)) {
                if ($records['padding'] || $records['size'] || $records['pos'] || $records['float'] || $records['opacity'] || $records['border']) {
                    $attrRecords[$attr->id] = $attr;
                }
            }
        }
        return isset($attrRecords) ? $attrRecords : [];
    }

    /**
     * 得到修改过的产品内容
     */
    public function getProCons()
    {
        $conModels = ProductConModel::where('productid',$this->id)->get();
        foreach ($conModels as $conModel) {
            if ($conModel->record) { $conRecord[$conModel->id] = $conModel; }
            if ($conModel->is_add) { $conAdd[$conModel->id] = $conModel; }
        }
        return array(
            'records'=> isset($conRecord)?$conRecord:[],
            'adds'=> isset($conAdd)?$conAdd:[],
        );
    }

    /**
     * 得到修改过的产品的关键帧
     */
    public function getProLayerAttrs()
    {
        $layerAttrs = ProductLayerAttrModel::where('productid',$this->id)->get();
        foreach ($layerAttrs as $layerAttr) {
            if ($layerAttr->record) { $layerAttrRecord[$layerAttr->id] = $layerAttr; }
            if ($layerAttr->is_add) { $layerAttrAdd[$layerAttr->id] = $layerAttr; }
        }
        return array(
            'records'=> isset($layerAttrRecord)?$layerAttrRecord:[],
            'adds'=> isset($layerAttrAdd)?$layerAttrAdd:[],
        );
    }

//    public function getVideo()
//    {
//        $videoModel = VideoModel::find($this->video_id);
//        return $videoModel ? $videoModel : '';
//    }
}