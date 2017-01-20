<?php
namespace App\Http\Controllers\Temp;

use App\Models\Temp\FrameModel;
use App\Models\Temp\LayerModel;

class LayerController extends BaseController
{
    /**
     * 模板动画设置
     */

    public function __construct()
    {
        $this->selfModel = new LayerModel();
    }

    public function index()
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
        $models = LayerModel::where('tempid',$tempid)->orderBy('delay','asc')->get();
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
            'model' =>  [],
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
        $model = LayerModel::find($id);
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
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'data'  =>  $datas,
            'model' =>  [],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 添加动画
     */
    public function store()
    {
        $name = $_POST['name'];
        $tempid = $_POST['tempid'];
        $timelong = $_POST['timelong'];
        $delay = $_POST['delay'];
        if (!$name || !$tempid) {
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
            'tempid'    =>  $tempid,
            'timelong'  =>  $timelong,
            'delay'     =>  $delay,
            'a_name'    =>  'layer_'.$tempid.'_'.rand(0,10000),
            'created_at'    =>  time(),
        ];
        LayerModel::create($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 修改动画
     */
    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $delay = $_POST['delay'];
        $timelong = $_POST['timelong'];
        $width = $_POST['width'];
        $height = $_POST['height'];
        $isborder = $_POST['isborder'];
        $border1 = $_POST['border1'];
        $border2 = $_POST['border2'];
        $border3 = $_POST['border3'];
        $isbg = $_POST['isbg'];
        $bg = $_POST['bg'];
        $iscolor = $_POST['iscolor'];
        $color = $_POST['color'];
        $fontsize = $_POST['fontsize'];
        $iscon = $_POST['iscon'];
        $text = $_POST['text'];
        $img = $_POST['img'];
        if (!$id || !$name) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = LayerModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $attrArr = [
            'width'     =>  $width,
            'height'    =>  $height,
            'isborder'  =>  $isborder,
            'border1'   =>  $border1,
            'border2'   =>  $border2,
            'border3'   =>  $border3,
            'isbg'      =>  $isbg,
            'bg'        =>  $bg,
            'iscolor'   =>  $iscolor,
            'color'     =>  $color,
            'fontsize'  =>  $fontsize,
        ];
        $conArr = [
            'iscon'     =>  $iscon,
            'text'      =>  $text,
            'img'       =>  $img,
        ];
        $data = [
            'name'      =>  $name,
            'timelong'  =>  $timelong,
            'delay'     =>  $delay,
            'attr'      =>  serialize($attrArr),
            'con'       =>  serialize($conArr),
            'updated_at'    =>  time(),
        ];
        LayerModel::where('id',$id)->update($data);
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }

    /**
     * 销毁记录
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
        $model = LayerModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '没有数据！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        //删除属性、内容、关键帧
        FrameModel::where('tempid',$model->tempid)
            ->where('layerid',$id)
            ->delete();
        LayerModel::where('id',$id)->delete();
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
        $rstArr = [
            'error' =>  [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
            'model' =>  [
//                'fontsizes' =>  $this->selfModel['fontsizes'],
                'border2s'  =>  $this->selfModel['border2s'],
                'border2names'  =>  $this->selfModel['border2names'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }
}