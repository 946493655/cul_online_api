<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

//$app->post('api/v1/product', function () use ($app) {
//    echo json_encode([]);exit;
//});


$app->group(['prefix' => 'api/v1', 'namespace'=>'App\Http\Controllers'], function () use ($app) {
    //平台发布的在线创作的产品模板
    $app->post('temp', 'TempProController@index');
    $app->post('temp/add', 'TempProController@store');
    $app->post('temp/setthumb', 'TempProController@setThumb');
    $app->post('temp/setlink', 'TempProController@setLink');
    $app->post('temp/modify', 'TempProController@update');
    $app->post('temp/show', 'TempProController@show');
    $app->post('temp/isshow', 'TempProController@setIsShow');
    $app->post('temp/delete', 'TempProController@forceDelete');
    $app->post('temp/getone', 'TempProController@getOneByShow');
    $app->post('temp/getmodel', 'TempProController@getModel');
    $app->post('temp/cleartable', 'TempProController@clearTable');
    $app->post('temp/all', 'TempProController@all');
    $app->post('temp/getpreview', 'TempProController@getPreview');
    $app->post('temp/setattr', 'TempProController@setAttr');
    //在线创作的产品
    $app->post('product', 'ProductController@index');
    $app->post('product/add', 'ProductController@store');
    $app->post('product/modify', 'ProductController@update');
    $app->post('product/show', 'ProductController@show');
    $app->post('product/setthumb', 'ProductController@setThumb');
    $app->post('product/setlink', 'ProductController@setLink');
    $app->post('product/onebyuid', 'ProductController@getOneByUid');
    $app->post('product/isshow', 'ProductController@setIsShow');
//    $app->post('product/delete', 'ProductController@forceDelete');
    $app->post('product/deleteby2id', 'ProductController@forceDeleteBy2Id');
    $app->post('product/getmodel', 'ProductController@getModel');
    $app->post('product/preview', 'ProductController@getPreview');
    //产品订单路由
    $app->post('order', 'OrderController@index');
    $app->post('order/add', 'OrderController@store');
//    $app->post('order/modifylink', 'OrderController@updateLink');
//    $app->post('order/show', 'OrderController@show');
//    $app->post('order/getorders', 'OrderController@getOrders');
//    $app->post('order/clear', 'OrderController@cleartable');
//    $app->post('order/isshow', 'OrderController@setIsShow');
//    $app->post('order/status', 'OrderController@setStatus');
    $app->post('order/ordersbyweal', 'OrderController@getOrdersByWeal');
    $app->post('order/getmodel', 'OrderController@getModel');
});


//模板的创作过程
$app->group(['prefix' => 'api/v1/t', 'namespace'=>'App\Http\Controllers\Temp'], function () use ($app) {
    //动画设置路由
    $app->post('layer', 'LayerController@index');
    $app->post('layer/show', 'LayerController@show');
    $app->post('layer/add', 'LayerController@store');
    $app->post('layer/modify', 'LayerController@update');
    $app->post('layer/setshow', 'LayerController@setIsShow');
    $app->post('layer/delete', 'LayerController@forceDelete');
    $app->post('layer/getmodel', 'LayerController@getModel');
    //动画关键帧路由
    $app->post('frame', 'FrameController@index');
    $app->post('frame/add', 'FrameController@store');
    $app->post('frame/modify', 'FrameController@update');
    $app->post('frame/getframesbytempid', 'FrameController@getFramesByTempid');
    $app->post('frame/onebytfid', 'FrameController@getFrameByTFid');
    $app->post('frame/delete', 'FrameController@forceDelete');
    $app->post('frame/getmodel', 'FrameController@getModel');
});


//产品的创作过程
$app->group(['prefix' => 'api/v1/pro', 'namespace'=>'App\Http\Controllers\Product'], function () use ($app) {
    //动画设置路由
    $app->post('layer', 'LayerController@index');
    $app->post('layer/show', 'LayerController@show');
    $app->post('layer/add', 'LayerController@store');
    $app->post('layer/modify', 'LayerController@update');
    $app->post('layer/setshow', 'LayerController@setIsShow');
    $app->post('layer/delete', 'LayerController@forceDelete');
    $app->post('layer/getmodel', 'LayerController@getModel');
    //动画关键帧路由
    $app->post('frame', 'FrameController@index');
//    $app->post('frame/add', 'FrameController@store');
//    $app->post('frame/modify', 'FrameController@update');
//    $app->post('frame/getmodel', 'FrameController@getModel');
    $app->post('frame/framesbyproid', 'FrameController@getFramesByProid');
//    $app->post('frame/delete', 'FrameController@forceDelete');
});