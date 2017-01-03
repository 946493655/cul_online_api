<?php
namespace App\Http\Controllers;

use App\Models\ProductModel;

class ProductController extends Controller
{
    /**
     * 产品控制器
     */

    public function __construct()
    {
        $this->selfModel = new ProductModel();
    }

    /**
     * 产品列表
     */
    public function index()
    {
        $uid = $_POST['uid'];
        $cate = $_POST['cate'];
        $isshow = $_POST['isshow'];
        $limit = isset($_POST['limit'])?$_POST['limit']:$this->limit;     //每页显示记录数
        $page = isset($_POST['page'])?$_POST['page']:1;         //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        $cateArr = $cate ? [$cate] : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];       //类别转为数组
        $isshowArr = $isshow ? [$isshow] : [0,1,2];     //是否显示转为数组
        if ($uid) {
            $models = ProductModel::where('uid',$uid)
                ->whereIn('cate',$cateArr)
                ->whereIn('isshow',$isshowArr)
                ->orderBy('id','desc')
                ->skip($start)
                ->take($limit)
                ->get();
        } else {
            $models = ProductModel::whereIn('cate',$cateArr)
                ->whereIn('isshow',$isshowArr)
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
            $datas[$k]['createTime'] = $model->createTime();
            $datas[$k]['updateTime'] = $model->updateTime();
            $datas[$k]['cateName'] = $model->getCateName();
            $datas[$k]['isTopName'] = $model->istop();
            $datas[$k]['isShowName'] = $model->isshow();
            $datas[$k]['linkTypes'] = $model->linkType();
        }
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '成功获取数据！',
            ],
            'data'  =>  $datas,
            'model' =>  [
                'cates'     =>  $this->selfModel['cates'],
                'isauths'   =>  $this->selfModel['isauths'],
                'istops'    =>  $this->selfModel['istops'],
                'isshows'   =>  $this->selfModel['isshows'],
                'formats'   =>  $this->selfModel['formats'],
                'formatNames'   =>  $this->selfModel['formatNames'],
                'linkTypes'   =>  $this->selfModel['linkTypes'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 通过 id 获取一条记录
     */
    public function show()
    {
        $id = $_POST['id'];
        if (!$id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数错误！',
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
        $datas['isTopName'] = $model->istop();
        $datas['isShowName'] = $model->isshow();
        $datas['linkTypes'] = $model->linkType();
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '获取成功！',
            ],
            'data'  =>  $datas,
            'model' =>  [
                'cates'     =>  $this->selfModel['cates'],
                'isauths'   =>  $this->selfModel['isauths'],
                'istops'    =>  $this->selfModel['istops'],
                'isshows'   =>  $this->selfModel['isshows'],
                'formats'   =>  $this->selfModel['formats'],
                'formatNames'   =>  $this->selfModel['formatNames'],
                'linkTypes'   =>  $this->selfModel['linkTypes'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 添加新产品
     */
    public function store()
    {
        $name = $_POST['name'];
        $cate = $_POST['cate'];
        $intro = $_POST['intro'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        $pid = $_POST['pid'];
        if (!$name || !$cate || !$gif || !$uid || !$uname) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数错误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'cate'  =>  $cate,
            'intro' =>  $intro,
            'uid'   =>  $uid,
            'uname' =>  $uname,
            'pid'   =>  $pid,
            'created_at'    =>  time(),
        ];
        ProductModel::create($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 修改产品
     */
    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $genre = $_POST['genre'];
        $cate = $_POST['cate'];
        $gif = $_POST['gif'];
        $intro = $_POST['intro'];
        $video_id = $_POST['video_id'];
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        $pid = $_POST['pid'];
        if (!$name || !$genre || !$cate || !$gif || !$uid || !$uname) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数错误！',
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
            'name'  =>  $name,
            'genre' =>  $genre,
            'cate'  =>  $cate,
            'gif'   =>  $gif,
            'intro' =>  $intro,
            'video_id'  =>  $video_id,
            'uid'   =>  $uid,
            'uname'   =>  $uname,
            'pid'   =>  $pid,
            'created_at'    =>  time(),
        ];
        ProductModel::create($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 设置是否删除
     */
    public function setIsShow()
    {
        $id = $_POST['id'];
        $isshow = $_POST['isshow'];
        if (!$id || !in_array($isshow,[0,1,2])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数错误！',
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
        $update = [
            'isshow'   =>  $isshow,
            'updated_at'    =>  time(),
        ];
        ProductModel::where('id',$id)->update($update);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 销毁数据
     */
    public function forceDelete()
    {
        $id = $_POST['id'];
        if (!$id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数错误！',
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
     * 获取 model 中数组
     */
    public function getModel()
    {
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'model' =>  [
                'cates'     =>  $this->selfModel['cates'],
                'isauths'   =>  $this->selfModel['isauths'],
                'istops'    =>  $this->selfModel['istops'],
                'isshows'   =>  $this->selfModel['isshows'],
                'formats'   =>  $this->selfModel['formats'],
                'formatNames'   =>  $this->selfModel['formatNames'],
                'linkTypes'   =>  $this->selfModel['linkTypes'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }
}