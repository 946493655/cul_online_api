<?php
namespace App\Models;

class OrderModel extends BaseModel
{
    /**
     * 用户意见model
     */
    protected $table = 'orders';
    protected $fillable = [
        'id','pro_id','serial','cate','uid','uname','format','money1','money2','weal','record','thumb','linkType','link','status','isshow','created_at','updated_at',
    ];
    //record：待处理字段，修改过的内容、属性、动画...

    //视频类型：1Flash代码，2html代码，2通用代码，4其他网址链接
    protected $linkTypes = [
        1=>'Flash代码','html代码','通用代码','其他网址链接',
    ];
    //订单状态：1待打款，2款不对，3待处理，4已处理待接收，5已接收待评价，6坏评价，7好评价并返利
    protected $statuss = [
        '所有','待付款','款不对','已付款处理中','已处理待接收','已接收待评价','评价不好','好评并返利',
    ];
    protected $isshows = [
        '所有','不显示','显示',
    ];

    /**
     * 得到在线模板信息
     */
    public function getProduct()
    {
        $productModel = ProductModel::find($this->pro_id);
        return $productModel ? $productModel : '';
    }

    /**
     * 得到创作订单名称
     */
    public function getProductName()
    {
        return $this->getProduct() ? $this->getProduct()->name : '';
    }

    /**
     * 渲染状态
     */
    public function getStatusName()
    {
        return array_key_exists($this->status,$this->statuss) ? $this->statuss[$this->status] : '';
    }
}