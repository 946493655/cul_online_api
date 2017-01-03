<?php
namespace App\Http\Controllers\Product;

use App\Models\Product\ProAttrModel;

class AttrController extends BaseController
{
    /**
     * 产品的属性控制器
     */

    /**
     * 列表
     */
    public function index()
    {
        $limit = isset($_POST['limit'])?$_POST['limit']:$this->limit;     //每页显示记录数
        $page = isset($_POST['page'])?$_POST['page']:1;         //页码，默认第一页
        $start = $limit * ($page - 1);      //记录起始id

        $models = ProAttrModel::orderBy('id','desc')
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
        $style_name = $_POST['style_name'];
        $productid = $_POST['productid'];
        $layerid = $_POST['layerid'];
        $genre = $_POST['genre'];
        $padding = $_POST['padding'];
        $size = $_POST['size'];
        $pos = $_POST['pos'];
        $float = $_POST['float'];
        $opacity = $_POST['opacity'];
        $border = $_POST['border'];
        if (!$name || !$style_name || !$productid || !$layerid || !$genre) {
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
            'style_name'    =>  $style_name,
            'productid'     =>  $productid,
            'layerid'       =>  $layerid,
            'genre'     =>  $genre,
            'padding'   =>  $padding,
            'size'      =>  $size,
            'pos'       =>  $pos,
            'float'     =>  $float,
            'opacity'   =>  $opacity,
            'border'    =>  $border,
            'created_at'    =>  time(),
        ];
        ProAttrModel::create($data);
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
        $style_name = $_POST['style_name'];
        $productid = $_POST['productid'];
        $layerid = $_POST['layerid'];
        $genre = $_POST['genre'];
        $padding = $_POST['padding'];
        $size = $_POST['size'];
        $pos = $_POST['pos'];
        $float = $_POST['float'];
        $opacity = $_POST['opacity'];
        $border = $_POST['border'];
        if (!$id || !$name || !$style_name || !$productid || !$layerid || !$genre) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -1,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $model = ProAttrModel::find($id);
        if (!$model) {
            $rstArr = [
                'error' =>  [
                    'code'  =>  -2,
                    'msg'   =>  '参数有误！',
                ],
            ];
            echo json_encode($rstArr);exit;
        }
        $data = [
            'name'  =>  $name,
            'style_name'    =>  $style_name,
            'productid'     =>  $productid,
            'layerid'       =>  $layerid,
            'genre'     =>  $genre,
            'padding'   =>  $padding,
            'size'      =>  $size,
            'pos'       =>  $pos,
            'float'     =>  $float,
            'opacity'   =>  $opacity,
            'border'    =>  $border,
            'created_at'    =>  time(),
        ];
        ProAttrModel::where('id',$id)->update($data);
        $rstArr = [
            'error' => [
                'code'  =>  0,
                'msg'   =>  '操作成功！',
            ],
        ];
        echo json_encode($rstArr);exit;
    }
}