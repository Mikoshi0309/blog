<?php
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Home\IndexController@index');
Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
Route::get('/art', 'Home\IndexController@article');
Route::get('/a/{art_id}', 'Home\IndexController@article');
Route::get('/sendMail', 'SwjTestController@sendMail');
Route::get('/password/reset/test',function (){
    return view('auth.passwords.reset');
});

/*****************Test********************/
Route::get('/testredis', 'SwjTestController@testredis');
//路由绑定模型测试
Route::get('/testroute/{name}', 'SwjTestController@testarticle');

Route::get('test', 'SwjTestController@test');
Route::get('extest', 'SwjTestController@extest');
Route::get('testexcel', 'SwjTestController@testexcel');
Route::get('testsetcache', 'SwjTestController@testsetcache');
Route::get('testgetcache/{page?}', 'SwjTestController@testgetcache');
Route::get('testqueue', 'SwjTestController@testqueue');


Route::get('testbb', 'SwjTestController@testbb');

//Route::get('checklogin', function(){
//    dd(Auth::viaRemember());
//    if (Auth::viaRemember()) {
//        return 'yes';
//    } else {
//        return 'no';
//    }
//});
/*********************************手动编写登录**************************/
Route::post('authenticate', 'Auth\AuthController@authenticate');
Route::get('testlogin', 'Auth\AuthController@testlogin');
Route::get('testlogout', 'Auth\AuthController@testlogout');



//Route::get('admin/crypt', 'Admin\LoginController@crypt');



Route::any('admin/login', 'Admin\LoginController@login');
Route::get('admin/code', 'Admin\LoginController@code');
Route::group(['middleware'=>['auth'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('/',['as'=>'website','uses'=> 'IndexController@index']);
    Route::get('info', 'IndexController@info');
    Route::get('loginout', 'LoginController@loginout');
    Route::post('cate/changeorder', 'CategoryController@changeorder');
    Route::post('upload', 'CommonController@upload');
    Route::any('pass', 'IndexController@pass');
    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::resource('link','LinkController');
    Route::post('link/changeorder', 'LinkController@changeorder');
    Route::resource('navs','NavsController');
    Route::post('navs/changeorder', 'NavsController@changeorder');
    Route::resource('config','ConfigController');
    Route::post('config/changeorder', 'ConfigController@changeorder');
    Route::post('config/changecontent', 'ConfigController@changecontent');
    Route::resource('tag','TagController');
});
Route::auth();

Route::get('/home', 'HomeController@index');
// 引导用户到新浪微博的登录授权页面
Route::get('auth/weibo', 'Auth\AuthController@weibo');
// 用户授权后新浪微博回调的页面
Route::get('auth/callback', 'Auth\AuthController@callback');
