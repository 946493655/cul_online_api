<?php
namespace App\Http\Controllers\Product;

use App\Models\Product\LayerModel;

class LayerController extends BaseController
{
    /**
     * 产品的动画设置控制器
     */

    public function __construct()
    {
        $this->selfModel = new LayerModel();
    }

    /**
     * 列表
     */
    public function index()
    {
        $pro_id = $_POST['pro_id'];
        $isshow = $_POST['isshow'];
        if (!$pro_id) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }

        $isshowArr = $isshow ? [$isshow] : [0,1,2];
        $models = LayerModel::where('pro_id',$pro_id)
            ->whereIn('isshow',$isshowArr)
            ->orderBy('delay','asc')
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
            $datas[$k]['pname'] = $model->getProductName();
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
        $datas['pname'] = $model->getProductName();
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
     * 添加属性
     */
    public function store()
    {
        $name = $_POST['name'];
        $tempid = $_POST['tempid'];
        $tl_id = $_POST['tlayerid'];
        $pro_id = $_POST['pro_id'];
        $timelong = $_POST['timelong'];
        $delay = $_POST['delay'];
        $uid = $_POST['uid'];
        if (!$name || !$tempid || !$tl_id || !$pro_id || !$uid) {
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
            'tempid'    =>  $tempid,
            'tl_id'     =>  $tl_id,
            'pro_id'    =>  $pro_id,
            'a_name'    =>  'layer_'.$uid.'_'.$pro_id.'_'.rand(0,10000),
            'timelong'  =>  $timelong,
            'delay'     =>  $delay,
            'created_at'    =>  time(),
        ];
        LayerModel::create($data);
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
        $timelong = $_POST['timelong'];
        $delay = $_POST['delay'];
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
        $isbigbg = $_POST['isbigbg'];
        $bigbg = $_POST['bigbg'];
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
        $conArr = [
            'iscon'     =>  $iscon,
            'text'      =>  $text,
            'img'       =>  $img,
        ];
        $attrs = [
            'width' =>  $width,
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
            'isbigbg'   =>  $isbigbg,
            'bigbg'   =>  $bigbg,
        ];
        $data = [
            'name' =>  $name,
            'timelong'  =>  $timelong,
            'delay'     =>  $delay,
            'attr'      =>  serialize($attrs),
            'con'       =>  $conArr ? serialize($conArr) : '',
            'updated_at'    =>  time(),
        ];
        LayerModel::where('id',$id)->update($data);
        $rstArr = [
            'error' => [
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
        if (!$id || !in_array($isshow,[1,2])) {
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
        $data = [
            'isshow'    =>  $isshow,
            'updated_at'    =>  time(),
        ];
        LayerModel::where('id',$id)->update($data);
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
        LayerModel::where('id',$id)->delete();
        $rstArr = [
            'error' => [
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
                'border2s'  =>  $this->selfModel['border2s'],
                'border2names'  =>  $this->selfModel['border2names'],
            ],
        ];
        echo json_encode($rstArr);exit;
    }
}