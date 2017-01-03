<?php
namespace App\Http\Controllers\Product;

use App\Models\Product\ProLayerModel;

class LayerController extends BaseController
{
    /**
     * 产品的动画设置控制器
     */

    /**
     * 列表
     */
    public function index()
    {
        $limit = isset($_POST['limit'])?$_POST['limit']:$this->limit;     //每页显示记录数
        $page = isset($_POST['page'])?$_POST['page']:1;         //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        $models = ProLayerModel::orderBy('id','desc')
            ->skip($start)
            ->take($limit)
            ->get();
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
     * 添加属性
     */
    public function store()
    {
        $name = $_POST['name'];
        $productid = $_POST['productid'];
        $a_name = $_POST['a_name'];
        $timelong = $_POST['timelong'];
        $func = $_POST['func'];
        $delay = $_POST['delay'];
        if (!$name || !$productid || !$a_name || !$func) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name' =>  $name,
            'productid' =>  $productid,
            'a_name'    =>  $a_name,
            'timelong'  =>  $timelong,
            'func'      =>  $func,
            'delay'     =>  $delay,
            'created_at'    =>  time(),
        ];
        ProLayerModel::create($data);
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 修改属性
     */
    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $productid = $_POST['productid'];
        $a_name = $_POST['a_name'];
        $timelong = $_POST['timelong'];
        $func = $_POST['func'];
        $delay = $_POST['delay'];
        if (!$id || !$name || !$productid || !$a_name || !$func) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProLayerModel::find($id);
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
            'name' =>  $name,
            'productid' =>  $productid,
            'a_name'    =>  $a_name,
            'timelong'  =>  $timelong,
            'func'      =>  $func,
            'delay'     =>  $delay,
            'updated_at'    =>  time(),
        ];
        ProLayerModel::where('id',$id)->update($data);
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
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
        $model = ProLayerModel::find($id);
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
     * 设置是否删除
     */
    public function setDel()
    {
        $id = $_POST['id'];
        $del = $_POST['del'];
        if (!$id || !in_array($del,[0,1])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProLayerModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        ProLayerModel::where('id',$id)->update(['del'=> $del]);
        $rstArr = [
            'error' => [
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
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProLayerModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        ProLayerModel::where('id',$id)->delete();
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }
}