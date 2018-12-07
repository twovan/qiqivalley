<?php

use Illuminate\Routing\Router;
Route::get('/',function (){
    return view('welcome');
});

Route::group([
    'prefix'        => 'backend',
    'namespace'     => 'Backend',
    'middleware'    => ['web'],
], function (Router $router) {

    $router->get('login', ['as' => 'backend.loginGet', 'uses' => 'PublicController@loginGet']);
    #$router->post('login', ['as' => 'backend.loginPost', 'uses' => 'PublicController@loginPost']);
    
    $router->get('logout', ['as' => 'backend.logout', 'uses' => 'PublicController@logout']);
    $router->post('upload/image', ['as' => 'backend.uploadImg', 'uses' => 'UploadController@image']);

    $router->get('index', ['as' => 'backend.index', 'uses' => 'IndexController@index']);
    $router->get('base', ['as' => 'backend.base', 'uses' => 'IndexController@base']);

    $router->get('admin', ['as' => 'backend.admin.index', 'uses' => 'AdminController@index']);
    $router->post('admin', ['as' => 'backend.admin.save', 'uses' => 'AdminController@save']);

    $router->get('store', ['as' => 'backend.store.index', 'uses' => 'StoreController@index']);
    $router->post('store', ['as' => 'backend.store.save', 'uses' => 'StoreController@save']);

    $router->get('customer', ['as' => 'backend.customer.index', 'uses' => 'UserController@customer']);
    $router->get('barber', ['as' => 'backend.barber.index', 'uses' => 'UserController@barber']);
    $router->post('user', ['as' => 'backend.user.save', 'uses' => 'UserController@save']);

    $router->get('kid', ['as' => 'backend.kid.index', 'uses' => 'KidController@index']);
    $router->post('kid', ['as' => 'backend.kid.save', 'uses' => 'KidController@save']);

    //充值
    $router->get('recharges', ['as' => 'backend.recharges.index', 'uses' => 'RechargesController@index']);
    $router->post('recharges', ['as' => 'backend.recharges.save', 'uses' => 'RechargesController@save']);

    //消费
    $router->get('costs', ['as' => 'backend.costs.index', 'uses' => 'CostsController@index']);
    $router->post('costsearch', ['as' => 'backend.costs.search', 'uses' => 'CostsController@index']);
    $router->post('costs', ['as' => 'backend.costs.save', 'uses' => 'CostsController@saveCost']);



    $router->get('borrow', ['as' => 'backend.borrow.index', 'uses' => 'BorrowController@index']);
    $router->post('borrow', ['as' => 'backend.borrow.save', 'uses' => 'BorrowController@save']);

    $router->get('material', ['as' => 'backend.material.index', 'uses' => 'MaterialController@index']);
    $router->post('material', ['as' => 'backend.material.save', 'uses' => 'MaterialController@save']);

    //课程记录
    $router->get('course', ['as' => 'backend.course.index', 'uses' => 'CourseController@index']);
    $router->post('course', ['as' => 'backend.course.save', 'uses' => 'CourseController@save']);


    $router->get('evaluate', ['as' => 'backend.evaluate.index', 'uses' => 'EvaluateController@index']);
    $router->post('evaluate', ['as' => 'backend.evaluate.save', 'uses' => 'EvaluateController@save']);

    $router->get('order', ['as' => 'backend.order.index', 'uses' => 'OrderController@index']);
    $router->post('order', ['as' => 'backend.order.save', 'uses' => 'OrderController@save']);

    $router->get('hair_style', ['as' => 'backend.hair_style.index', 'uses' => 'HairStyleController@index']);
    $router->post('hair_style', ['as' => 'backend.hair_style.save', 'uses' => 'HairStyleController@save']);

    $router->get('service', ['as' => 'backend.service.index', 'uses' => 'ServiceController@index']);
    $router->post('service', ['as' => 'backend.service.save', 'uses' => 'ServiceController@save']);
});

Route::group([
    'prefix'        => 'index',
    'namespace'     => 'Index',
    'middleware'    => ['web'],
], function (Router $router) {
    $router->get('index', ['as' => 'index.index', 'uses' => 'IndexController@index']);
    $router->get('base', ['as' => 'index.base', 'uses' => 'IndexController@base']);

    $router->get('login', ['as' => 'index.loginGet', 'uses' => 'PublicController@loginGet']);
    #$router->post('login', ['as' => 'index.loginPost', 'uses' => 'PublicController@loginPost']);
    $router->get('logout', ['as' => 'index.logout', 'uses' => 'PublicController@logout']);
    $router->get('web_store/{id}', 'PublicController@store');
    $router->get('showstore/{id}', 'PublicController@showstore');
    $router->get('video', ['as' => 'index.video.video', 'uses' => 'PublicController@video']);
    $router->get('order', ['as' => 'index.order.index', 'uses' => 'OrderController@index']);
    $router->get('order/image/{id}', ['as' => 'index.order.image', 'uses' => 'OrderController@image']);
    $router->post('order/image', ['as' => 'index.order.uploadImage', 'uses' => 'OrderController@uploadImage']);


});


Route::group([
    'middleware'    => ['api'],
], function (Router $router) {
    $router->post('backend/login', ['as' => 'backend.loginPost', 'uses' => 'Backend\PublicController@loginPost']);

    $router->post('index/login', ['as' => 'index.loginPost', 'uses' => 'Index\PublicController@loginPost']);
});
