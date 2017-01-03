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
    //在线创作的产品
    $app->post('product', 'ProductController@index');
    $app->post('product/add', 'ProductController@store');
    $app->post('product/modify', 'ProductController@update');
    $app->post('product/show', 'ProductController@show');
    $app->post('product/isshow', 'ProductController@setIsShow');
    $app->post('product/delete', 'ProductController@forceDelete');
    $app->post('product/getmodel', 'ProductController@getModel');
    //产品订单路由
    $app->post('order', 'OrderController@index');
    $app->post('order/add', 'OrderController@store');
    $app->post('order/modifylink', 'OrderController@updateLink');
    $app->post('order/show', 'OrderController@show');
    $app->post('order/getorders', 'OrderController@getOrders');
    $app->post('order/getmodel', 'OrderController@getModel');
    $app->post('order/clear', 'OrderController@cleartable');
    $app->post('order/isshow', 'OrderController@setIsShow');
    $app->post('order/status', 'OrderController@setStatus');
    //平台发布的在线创作的产品模板
    $app->post('temp', 'TempProController@index');
    $app->post('temp/show', 'TempProController@show');
    $app->post('temp/getmodel', 'TempProController@getModel');
});


//在线创作产品的过程
$app->group(['prefix' => 'api/v1', 'namespace'=>'App\Http\Controllers\Product'], function () use ($app) {
    //属性的路由
    $app->post('attr', 'AttrController@index');
    $app->post('attr/add', 'AttrController@store');
    $app->post('attr/modify', 'AttrController@update');
    $app->post('attr/show', 'AttrController@show');
    $app->post('attr/isdel', 'AttrController@setDel');
    $app->post('attr/delete', 'AttrController@forceDelete');
    //内容路由
    $app->post('con', 'ConController@index');
    $app->post('con/add', 'AttrController@store');
    $app->post('con/modify', 'AttrController@update');
    //动画设置路由
    $app->post('layer', 'LayerController@index');
    $app->post('layer/add', 'LayerController@store');
    $app->post('layer/modify', 'LayerController@update');
    $app->post('layer/show', 'LayerController@show');
    $app->post('layer/isdel', 'LayerController@setDel');
    $app->post('layer/delete', 'LayerController@forceDelete');
    //属性的动画路由
    $app->post('layerattr', 'LayerAttrController@index');
});