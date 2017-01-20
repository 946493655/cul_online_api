<?php
namespace App\Http\Controllers\Temp;

use App\Models\Temp\FrameModel;
use App\Models\Temp\LayerModel;

class FrameController extends BaseController
{
    /**
     * 动画关键帧
     */

    public function __construct()
    {
        $this->selfModel = new FrameModel();
    }

    public function index()
    {
        $tempid = $_POST['tempid'];
        $layerid = $_POST['layerid'];
        $attr = $_POST['attr'];

        $layerModel = LayerModel::where('tempid',$tempid)->where('id',$layerid)->first();
        if (!$layerModel || !array_key_exists($attr,$this->selfModel['attrs'])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $attrArr = $attr ? [$attr] : [1,2,3];
        $models = FrameModel::where('tempid',$tempid)
            ->where('layerid',$layerid)
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
            $datas[$model->id] = $this->objToArr($model);
            $datas[$model->id]['createTime'] = $model->createTime();
            $datas[$model->id]['updateTime'] = $model->updateTime();
            $datas[$model->id]['getAttr'] = $model->getAttr();
            $datas[$model->id]['getAttrName'] = $model->getAttrName();
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
            'model' =>  [
                'attrs'  =>  $this->selfModel['attrs'],
                'attrNames'  =>  $this->selfModel['attrNames'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 通过 tempid 获取记录
     */
    public function getFramesByTempid()
    {
        $tempid = $_POST['tempid'];
        if (!$tempid) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = FrameModel::where('tempid',$tempid)->get();
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
            $datas[$model->id] = $this->objToArr($model);
            $datas[$model->id]['createTime'] = $model->createTime();
            $datas[$model->id]['updateTime'] = $model->updateTime();
            $datas[$model->id]['getAttr'] = $model->getAttr();
            $datas[$model->id]['getAttrName'] = $model->getAttrName();
            $datas[$model->id]['layerName'] = $model->getLayerName();
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
            'model' =>  [
                'attrs'  =>  $this->selfModel['attrs'],
                'attrNames'  =>  $this->selfModel['attrNames'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    public function store()
    {
        $tempid = $_POST['tempid'];
        $layerid = $_POST['layerid'];
        $attr = $_POST['attr'];
        $per = $_POST['per'];
        $val = $_POST['val'];
        $layerModel = LayerModel::where('tempid',$tempid)->where('id',$layerid)->first();
        if (!$layerModel || !array_key_exists($attr,$this->selfModel['attrs'])) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'tempid'    =>  $tempid,
            'layerid'   =>  $layerid,
            'attr'      =>  $attr,
            'per'       =>  $per,
            'val'       =>  $val,
            'created_at'    =>  time(),
        ];
        FrameModel::create($data);
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
        $frames = $_POST['frames'];
        $frameids = $_POST['frameids'];
        if (!$frames) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $models = FrameModel::whereIn('id',$frameids)->get();
        if (!count($models) || count($models)!=count($frames)) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据或数据不对！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        foreach ($frames as $frame) {
            $data = [
                'per'   =>  $frame['per'],
                'val'   =>  $frame['val'],
                'updated_at'    =>  time(),
            ];
            FrameModel::where('id',$frame['id'])->update($data);
        }
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

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