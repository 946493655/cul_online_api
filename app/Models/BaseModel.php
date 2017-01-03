<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;

    //支持 GoodsModel、WorksModel
    //样片类型：1电视剧，2电影，3微电影，4广告，5宣传片，6专题片，7汇报片，8主题片，9纪录片，10晚会，11淘宝视频，12婚纱摄影 ,13节日聚会，14个人短片
    protected $cates = [
        1=>'电视剧','电影','微电影','广告','宣传片','专题片','汇报片','主题片','纪录片','晚会','淘宝视频','婚庆摄影','节日聚会','个人短片',
    ];
    //链接类型：1Flash代码，2html代码，3通用代码，4其他网址链接
    protected $linkTypes = [
        1=>'Flash代码','html代码','通用代码','其他网址链接',
    ];
    //支持 OrderModel、OrdersFirmModel、OrdersProdustModel
    //视频格式：网络版640*480，标清720*576，小高清1280*720，高清1920*1080，
    protected $formats = [
        1=>'640*480','720*576','1280*720','1920*1080',
    ];
    protected $formatNames = [
        1=>'网络版','标清','小高清','高清',
    ];
    protected $formatMoneys = [
        1=>40,60,80,100
    ];
    protected $isshows = [
        1=>'不显示','显示',
    ];

    /**
     * 样片类型
     */
    public function getCateName()
    {
        return array_key_exists($this->cate,$this->cates) ? $this->cates[$this->cate] : '';
    }

    /**
     * 视频链接类型
     */
    public function getLinkTypeName()
    {
        return array_key_exists($this->linkType,$this->linkTypes) ? $this->linkTypes[$this->linkType] : '';
    }

    /**
     * 渲染的格式
     */
    public function getFormatName()
    {
        return array_key_exists($this->format,$this->formatNames) ? $this->formatNames[$this->format] : '';
    }

    /**
     * 渲染的格式
     */
    public function getFormatMoney()
    {
        return array_key_exists($this->format,$this->formatMoneys) ? $this->formatMoneys[$this->format] : '';
    }

    public function isshow()
    {
        return array_key_exists($this->isshow,$this->isshows) ? $this->isshows[$this->isshow] : '';
    }

    /**
     * 创建时间转换
     */
    public function createTime()
    {
        return $this->created_at ? date("Y年m月d日 H:i", $this->created_at) : '';
    }

    /**
     * 更新时间转换
     */
    public function updateTime()
    {
        return $this->updated_at ? date("Y年m月d日 H:i", $this->updated_at) : '未更新';
    }
}