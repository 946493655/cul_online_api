<?php
namespace App\Http\Controllers\Product;

use App\Models\Product\FrameModel;

class FrameController extends BaseController
{
    /**
     * 产品关键帧
     */

    public function __construct()
    {
        $this->selfModel = new FrameModel();
    }

    public function index()
    {
        $pro_id = $_POST['pro_id'];
        $layer = $_POST['layerid'];
        $attr = $_POST['attr'];
        if (!$pro_id || !$layer) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $attrArr = $attr ? [$attr] : [1,2,3,4,5];
        $models = FrameModel::where('pro_id',$pro_id)
            ->where('layerid',$layer)
            ->whereIn('attr',$attrArr)
            ->orderBy('per','asc')
            ->get();
        if (!count($models)) {
            $rstArr = [
                'error' =>  [
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
     * 通过 pro_id 获取产品关键帧集合
     */
    public function getFramesByProid()
    {
        $pro_id = $_POST['pro_id'];
        if (!$pro_id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = FrameModel::where('pro_id',$pro_id)->orderBy('per','asc')->get();
        if (!count($models)) {
            $rstArr = [
                'error' =>  [
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

    public function update()
    {
        $id = $_POST['id'];
        $attr = $_POST['attr'];
        $per = $_POST['per'];
        $val = $_POST['val'];
        if (!$id || !$attr) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = FrameModel::where('id',$id)
            ->where('attr',$attr)
            ->first();
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
            'per'   =>  $per,
            'val'   =>  $val,
            'updated_at'    =>  time(),
        ];
        FrameModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /** 获取 model
     */
    public function getModel()
    {
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'model' =>  [
                'attrs'  =>  $this->selfModel['attrs'],
                'attrNames'  =>  $this->selfModel['attrNames'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }
}