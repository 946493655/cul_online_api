<?php
namespace App\Http\Controllers;

use App\Models\OrderModel;

class OrderController extends Controller
{
    /**
     * 订单控制器
     */

    public function __construct()
    {
        $this->selfModel = new OrderModel();
    }

    /**
     * 列表
     */
    public function index()
    {
        $uid = $_POST['uid'];
        $cate = $_POST['cate'];
        $status = isset($_POST['status'])?$_POST['status']:0;
        $isshow = $_POST['isshow'];
        $limit = (isset($_POST['limit'])&&$_POST['limit'])?$_POST['limit']:$this->limit;     //每页显示记录数
        $page = isset($_POST['page'])?$_POST['page']:1;         //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        $cateArr = $cate ? array($cate) : array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
        $isshowArr = $isshow ? array($isshow) : array(0,1,2);
        $statusArr = $status ? array($status) : array(0,1,2,3,4,5,6,7,8,9,10);
        if ($uid) {
            $models = OrderModel::where('uid',$uid)
                ->whereIn('cate',$cateArr)
                ->whereIn('status',$statusArr)
                ->whereIn('isshow',$isshowArr)
                ->whereIn('del',0)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        } else {
            $models = OrderModel::whereIn('cate',$cateArr)
                ->whereIn('status',$statusArr)
                ->whereIn('isshow',$isshowArr)
                ->whereIn('del',0)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        }
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
            $datas[$k]['pname'] = $model->getProductName();
            $datas[$k]['cateName'] = $model->getCateName();
            $datas[$k]['statusName'] = $model->getStatusName();
            $datas[$k]['formatName'] = $model->getFormatName();
            $datas[$k]['formatMoney'] = $model->getFormatMoney();
            $datas[$k]['isShowName'] = $model->isshow();
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
        }
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '成功获取数据！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 uid、limit 获取数据
     */
    public function getOrders()
    {
        $uid = $_POST['uid'];
        $limit = $_POST['limit'];
        if ($uid && $limit) {
            $models = OrderModel::where('uid',$uid)
                ->orderBy('id','desc')
                ->skip(0)
                ->take($limit)
//                ->paginate($limit);
                ->get();
        } elseif (!$uid && $limit) {
            $models = OrderModel::orderBy('id','desc')
                ->skip(0)
                ->take($limit)
                ->get();
        } elseif ($uid && !$limit) {
            $models = OrderModel::where('uid',$uid)
                ->orderBy('id','desc')
                ->get();
        } elseif (!$uid && !$limit) {
            $models = OrderModel::orderBy('id','desc')->get();
        }
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
            $datas[$k]['pname'] = $model->getProductName();
            $datas[$k]['cateName'] = $model->getCateName();
            $datas[$k]['statusName'] = $model->getStatusName();
            $datas[$k]['formatName'] = $model->getFormatName();
            $datas[$k]['formatMoney'] = $model->getFormatMoney();
            $datas[$k]['isShowName'] = $model->isshow();
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
        }
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '成功获取数据！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 通过 uid、weal 获取已支付福利记录
     */
    public function getOrdersByWeal()
    {
        $uid = $_POST['uid'];
        $cate = $_POST['cate'];
        $isshow = $_POST['isshow'];
        $del = $_POST['del'];
        $limit = (isset($_POST['limit'])&&$_POST['limit'])?$_POST['limit']:$this->limit;     //每页显示记录数
        $page = isset($_POST['page'])?$_POST['page']:1;         //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        $cateArr = $cate ? array($cate) : array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
        $isshowArr = $isshow ? array($isshow) : array(0,1,2);
        if ($uid) {
            $models = OrderModel::where('del',$del)
                ->where('uid',$uid)
                ->where('weal','>',0)
                ->whereIn('cate',$cateArr)
                ->whereIn('status',[4,5,6,7])
                ->whereIn('isshow',$isshowArr)
                ->whereIn('del',0)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        } else {
            $models = OrderModel::where('del',$del)
                ->where('weal','>',0)
                ->whereIn('cate',$cateArr)
                ->whereIn('status',[4,5,6,7])
                ->whereIn('isshow',$isshowArr)
                ->whereIn('del',0)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        }
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
            $datas[$k]['pname'] = $model->getProductName();
            $datas[$k]['cateName'] = $model->getCateName();
            $datas[$k]['statusName'] = $model->getStatusName();
            $datas[$k]['formatName'] = $model->getFormatName();
            $datas[$k]['formatMoney'] = $model->getFormatMoney();
            $datas[$k]['isShowName'] = $model->isshow();
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
        }
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '成功获取数据！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 添加订单
     */
    public function store()
    {
        $pro_id = $_POST['pro_id'];
        $cate = $_POST['cate'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        $format = $_POST['format'];
        $money = $_POST['money'];
        $weal = $_POST['weal'];
        $money1 = $_POST['money1'];
        if (!$pro_id || !$cate || !$uid || !$uname || !$format) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        if (!$money && !$weal && !$money1) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'pro_id' =>  $pro_id,
            'serial'    =>  date('YmdHis',time()).rand(0,10000),
            'cate'  =>  $cate,
            'uid'   =>  $uid,
            'uname' =>  $uname,
            'format'    =>  $format,
            'money'    =>  $money,
            'weal'      =>  $weal,
            'money1'    =>  $money1,
            'created_at'    =>  time(),
        ];
        OrderModel::create($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 更新视频链接
     */
    public function updateLink()
    {
        $id = $_POST['id'];
        $thumb = $_POST['thumb'];
        $linkType = $_POST['linkType'];
        $link = $_POST['link'];
        if (!$id || !$thumb || !$linkType || !$link) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = OrderModel::find($id);
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
            'thumb' =>  $thumb,
            'linkType'  =>  $linkType,
            'link'  =>  $link,
            'updated_at'    =>  time(),
        ];
        OrderModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 根据 id 获取一条记录
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
        $model = OrderModel::find($id);
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
        $datas['pname'] = $model->getProductName();
        $datas['cateName'] = $model->getCateName();
        $datas['statusName'] = $model->getStatusName();
        $datas['formatName'] = $model->getFormatName();
        $datas['formatMoney'] = $model->getFormatMoney();
        $datas['isShowName'] = $model->isshow();
        $datas['createTime'] = $model->createTime();
        $datas['updateTime'] = $model->updateTime();
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '成功获取数据！',
            ],
            'data'  =>  $datas,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 通过 id、isshow 设置是否显示
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
        $model = OrderModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        OrderModel::where('id',$id)->update(['isshow'=> $isshow]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置状态
     */
    public function setStatus()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        if (!$id || $status) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = OrderModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        OrderModel::where('id',$id)->update(['status'=> $status]);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 获取 model
     */
    public function getModel()
    {
        $arr = array(
            'cates'         =>  $this->selfModel['cates'],
            'linkTypes'     =>  $this->selfModel['linkTypes'],
            'formats'       =>  $this->selfModel['formats'],
            'formatNames'   =>  $this->selfModel['formatNames'],
            'formatMoneys'  =>  $this->selfModel['formatMoneys'],
            'statuss'   =>  $this->selfModel['statuss'],
            'isshows'   =>  $this->selfModel['isshows'],
        );
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'model' =>  $arr,
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 清空表
     */
    public function cleartable()
    {
        $uname = $_POST['uname'];
        if (!$uname) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        if ($uname!='jiuge') {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '没有权限！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        OrderModel::truncate();
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }
}