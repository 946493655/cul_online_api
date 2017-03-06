<?php
namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\Product\LayerModel as ProLayerModel;
use App\Models\Product\FrameModel as ProFrameModel;
use App\Models\Temp\LayerModel as TempLayerModel;
use App\Models\Temp\FrameModel as TempFrameModel;
use App\Models\TempProModel;

class ProductController extends Controller
{
    /**
     * 用户产品控制器
     */

    public function __construct()
    {
        $this->selfModel = new ProductModel();
    }

    public function index()
    {
        $uid = ($_POST['uid']&&$_POST['uid']) ? $_POST['uid'] : 0;
        $isshow = ($_POST['isshow']&&$_POST['isshow']) ? $_POST['isshow'] : 0;
        $limit = (isset($_POST['limit'])&&$_POST['limit'])?$_POST['limit']:$this->limit;     //每页显示记录数
        $page = isset($_POST['page'])?$_POST['page']:1;         //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        if ($uid) {
            $models = ProductModel::where('uid',$uid)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = ProductModel::where('uid',$uid)
                ->whereIn('isshow',$isshowArr)
                ->count();
        } else {
            $models = ProductModel::whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
            $total = ProductModel::whereIn('isshow',$isshowArr)->count();
        }
        if (!count($models)) {
            $rstArr = [
                'error' => [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = array();
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['tempName'] = $model->getTempName();
            $datas[$k]['cateName'] = $model->getCateName();
            $datas[$k]['linkTypeName'] = $model->getLinkTypeName();
            $datas[$k]['isShowName'] = $model->isshow();
        }
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
            'pagelist'  =>  [
                'total' =>  $total,
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 通过 id、uid 获取记录
     */
    public function getOneByUid()
    {
        $id = $_POST['id'];
        $uid = $_POST['uid'];
        if (!$id || !$uid) {
            $rstArr = [
                'error' =>  [
                    'error' =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::where('id',$id)->where('uid',$uid)->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'error' =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->objToArr($model);
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $datas['tempName'] = $model->getTempName();
        $datas['cateName'] = $model->getCateName();
        $datas['linkTypeName'] = $model->getLinkTypeName();
        $datas['isShowName'] = $model->isshow();
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    public function store()
    {
        $name = $_POST['name'];
        $intro = $_POST['intro'];
        $tempid = $_POST['tempid'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        if (!$tempid || !$uid || !$uname) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $tempModel = TempProModel::find($tempid);
        if (!$tempModel) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $tempLayers = TempLayerModel::where('tempid',$tempModel->id)->get();
        if (!$tempLayers) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -3,
                    'msg'   =>  '没有动画数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $tempFrames = TempFrameModel::where('tempid',$tempModel->id)->get();
        if (!$tempFrames) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -4,
                    'msg'   =>  '没有关键帧数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $product = ProductModel::where('tempid',$tempid)->where('uid',$uid)->first();
        if ($product) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -5,
                    'msg'   =>  '该用户已有此模板的产品！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $time = time();
        $data = [
            'name'  =>  $name,
            'cate'  =>  $tempModel->cate,
            'intro'     =>  $intro,
            'tempid'    =>  $tempid,
            'uid'       =>  $uid,
            'uname'     =>  $uname,
//            'thumb'     =>  $tempModel->thumb,
            'linkType'  =>  $tempModel->linkType,
            'link'      =>  $tempModel->link,
            'created_at'    =>  $time,
        ];
        ProductModel::create($data);
        //获取刚插入的product，增加 pro_layer 记录
        $productModel = ProductModel::where($data)->first();
        if (!$this->addLayer($productModel,$tempLayers,$uid)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -6,
                    'msg'   =>  '获取产品动画层错误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        //获取刚插入的pro_id，增加 pro_frame 记录
        if (!$this->addFrame($productModel,$tempFrames)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -7,
                    'msg'   =>  '获取产品关键帧错误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 复制模板的动画层，循环插入
     */
    public function addLayer($product,$layers,$uid)
    {
        foreach ($layers as $layer) {
            $data = [
                'name'  =>  $layer->name,
                'a_name'    =>  'layer_'.$uid.'_'.$product->id.'_'.rand(0,10000),
                'tl_id'     =>  $layer->id,
                'pro_id'    =>  $product->id,
                'timelong'  =>  $layer->timelong,
                'delay'     =>  $layer->delay,
                'con'       =>  $layer->con,
                'attr'      =>  $layer->attr,
                'created_at'    =>  time(),
            ];
            ProLayerModel::create($data);
        }
        return true;
    }

    /**
     * 复制模板的关键帧，循环插入
     */
    public function addFrame($product,$frames)
    {
        foreach ($frames as $frame) {
            $data = [
                'pro_id'    =>  $product->id,
                'layerid'   =>  $frame->layerid,
                'tf_id'     =>  $frame->id,
                'attr'      =>  $frame->attr,
                'per'       =>  $frame->per,
                'val'       =>  $frame->val,
                'created_at'    =>  time(),
            ];
            ProFrameModel::create($data);
        }
        return true;
    }

    public function show()
    {
        $id = $_POST['id'];
        if (!$id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = $this->objToArr($model);
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $datas['cateName'] = $model->getCateName();
        $datas['linkTypeName'] = $model->getLinkTypeName();
        $datas['isShowName'] = $model->isshow();
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 用户产品信息更新
     */
    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $intro = $_POST['intro'];
        $uid = $_POST['uid'];
        if (!$id || !$name || !$intro || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::where('id',$id)->where('uid',$uid)->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'intro' =>  $intro,
            'updated_at'    =>  time(),
        ];
        ProductModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 id 更新模板的TempProduct的 thumb
     */
    public function setThumb()
    {
        $id = $_POST['id'];
        $thumb = $_POST['thumb'];
        $uid = $_POST['uid'];
        if (!$id || !$thumb || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::where('id',$id)->where('uid',$uid)->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'thumb'     =>  $thumb,
            'updated_at'    =>  time(),
        ];
        ProductModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 id 更新模板的TempProduct的 linkType、link
     */
    public function setLink()
    {
        $id = $_POST['id'];
        $linkType = $_POST['linkType'];
        $link = $_POST['link'];
        $uid = $_POST['uid'];
        if (!$id || !$linkType || !$link || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::where('id',$id)->where('uid',$uid)->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'linkType'  =>  $linkType,
            'link'      =>  $link,
            'updated_at'    =>  time(),
        ];
        ProductModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置产品背景
     */
    public function setAttr()
    {
        $id = $_POST['id'];
        $isbg = $_POST['isbg'];
        $bgcolor = $_POST['bgcolor'];
        $bgimg = $_POST['bgimg'];
        if (!$id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'isbg'  =>  $isbg,
            'bgcolor'   =>  $bgcolor,
            'bgimg'     =>  $bgimg,
        ];
        ProductModel::where('id',$id)->update(['attr'=>serialize($data)]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置是否显示
     */
    public function setShow()
    {
        $id = $_POST['id'];
        $isshow = $_POST['isshow'];
        if (!$id || !in_array($isshow,[1,2])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        ProductModel::where('id',$id)->update(['isshow'=>$isshow]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    public function forceDeleteBy2Id()
    {
        $id = $_POST['id'];
        $uid = $_POST['uid'];
        if (!$id || !$uid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProductModel::where('id',$id)->where('uid',$uid)->first();
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $layers = ProLayerModel::where('id',$id)->where('uid',$uid)->get();
        if (count($layers)) {
            foreach ($layers as $layer) { ProLayerModel::where('id',$layer->id)->delete(); }
        }
        ProductModel::where('id',$id)->delete();
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 获取动画预览数据
     */
    public function getPreview()
    {
        $id = $_POST['id'];
        $isshow = $_POST['isshow'];
        if (!$id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $isShowArr = $isshow ? [$isshow] : [0,1,2];
        $model = ProductModel::find($id);
        $layerModels = ProLayerModel::where('pro_id',$id)
            ->whereIn('isshow',$isShowArr)
            ->get();
        if (!$model || !count($layerModels)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $datas = array();
        $datas['pro'] = $this->objToArr($model);
        $datas['pro']['createTime'] = $model->createTime();
        $datas['pro']['updateTime'] = $model->updateTime();
        foreach ($layerModels as $k=>$layerModel) {
            $datas['layer'][$k] = $this->objToArr($layerModel);
            $datas['layer'][$k]['createTime'] = $layerModel->createTime();
            $datas['layer'][$k]['updateTime'] = $layerModel->updateTime();
            $datas['layer'][$k]['con'] = $layerModel->getCons();
            $datas['layer'][$k]['attr'] = $layerModel->getAttrs();
            //关键帧属性
            $datas['layer'][$k]['leftArr'] = $layerModel->getFrames(1) ?
                $this->objToArr($layerModel->getFrames(1)) : [];
            $datas['layer'][$k]['topArr'] = $layerModel->getFrames(2) ?
                $this->objToArr($layerModel->getFrames(2)) : [];
            $datas['layer'][$k]['opacityArr'] = $layerModel->getFrames(3) ?
                $this->objToArr($layerModel->getFrames(3)) : [];
            $datas['layer'][$k]['rotateArr'] = $layerModel->getFrames(4) ?
                $this->objToArr($layerModel->getFrames(4)) : [];
            $datas['layer'][$k]['scaleArr'] = $layerModel->getFrames(5) ?
                $this->objToArr($layerModel->getFrames(5)) : [];
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 获取产品model
     */
    public function getModel()
    {
        $model = [
            'cates'     =>  $this->selfModel['cates'],
            'linkTypes' =>  $this->selfModel['linkTypes'],
            'isshows'    =>  $this->selfModel['isshows'],
        ];
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'model' =>  $model,
        ];
        echo json_encode($rstArr);exit;
    }
}