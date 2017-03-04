<?php
namespace App\Http\Controllers;

use App\Models\Temp\AttrModel;
use App\Models\Temp\ConModel;
use App\Models\Temp\LayerModel;
use App\Models\TempProModel;

class TempProController extends Controller
{
    /**
     * 产品模板控制器
     */

    public function __construct()
    {
        $this->selfModel = new TempProModel();
    }

    public function index()
    {
        $cate = ($_POST['cate']&&$_POST['cate']) ? $_POST['cate'] : 0;
        $isshow = ($_POST['isshow']&&$_POST['isshow']) ? $_POST['isshow'] : 0;
        $limit = (isset($_POST['limit'])&&$_POST['limit'])?$_POST['limit']:$this->limit;     //每页显示记录数
        $page = isset($_POST['page'])?$_POST['page']:1;         //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        $cateArr = $cate ? [$cate] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $models = TempProModel::whereIn('cate',$cateArr)
            ->whereIn('isshow',$isshowArr)
            ->orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
        $total = TempProModel::whereIn('cate',$cateArr)
            ->whereIn('isshow',$isshowArr)
            ->count();
        if (!count($models)) {
            $rstArr = [
                'error' => [
                    'code'  =>  -2,
                    'msg'   =>  '未获取到数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        //整理数据
        $datas = array();
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
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
     * 获取所有模板
     */
    public function all()
    {
        $models = TempProModel::where('isshow',2)->get();
        if (!count($models)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        //整理数据
        $datas = array();
        foreach ($models as $k=>$model) {
            $datas[$k] = $this->objToArr($model);
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
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
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 id 获取记录
     */
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
        $model = TempProModel::find($id);
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
            'error' => [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 id 获取记录
     */
    public function getOneByShow()
    {
        $id = $_POST['id'];
        $isshow = (isset($_POST['isshow'])&&$_POST['isshow']) ? $_POST['isshow'] : 0;
        if (!$id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = TempProModel::where('id',$id)->where('isshow',$isshow)->first();
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
        $cate = $_POST['cate'];
        $intro = $_POST['intro'];
        if (!$name || !$cate || !$intro) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'cate'  =>  $cate,
            'intro' =>  $intro,
            //AE_ + 年月日时分秒 + 随机值
            'serial'    =>  'AE_'.date('YmdHis',time()).rand(0,10000),
            'created_at'    =>  time(),
        ];
        TempProModel::create($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $cate = $_POST['cate'];
        $intro = $_POST['intro'];
        if (!$id || !$name || !$cate || !$intro) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = TempProModel::find($id);
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
            'cate'  =>  $cate,
            'intro' =>  $intro,
            'updated_at'    =>  time(),
        ];
        TempProModel::where('id',$id)->update($data);
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
        if (!$id || !$thumb) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = TempProModel::find($id);
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
        TempProModel::where('id',$id)->update($data);
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
        if (!$id || !$linkType || !$link) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = TempProModel::find($id);
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
        TempProModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 更新模板大背景
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
        $model = TempProModel::find($id);
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
        TempProModel::where('id',$id)->update(['attr'=>serialize($data)]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 id 设置 isshow
     */
    public function setIsShow()
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
        $model = TempProModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        TempProModel::where('id',$id)->update(['isshow'=> $isshow]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 id 销毁记录
     */
    public function forceDelete()
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
        $model = TempProModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        TempProModel::where('id',$id)->delete();
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 清空表：只有九哥有权限
     */
    public function clearTable()
    {
        $adminName = $_POST['adminName'];
        if (!$adminName || $adminName!='jiuge') {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = TempProModel::all();
        if (!count($models)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        TempProModel::truncate();
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
        $model = TempProModel::find($id);
        $isShowArr = $isshow ? [$isshow] : [1,2];
        $layerModels = LayerModel::where('tempid',$id)
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
        $datas['temp'] = $this->objToArr($model);
        $datas['temp']['createTime'] = $model->createTime();
        $datas['temp']['updateTime'] = $model->updateTime();
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
     * 获取 model
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