<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::any('/','Home\IndexController@index');

Route::any('admin/login','Admin\LoginController@index');
Route::post('admin/log','Admin\LoginController@log');

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['iflogin']],function(){
	Route::get('/','IndexController@index');
	Route::get('logout','LoginController@logout');
	Route::get('addrecycle/id/{id}/recycle/{recycle}','ArticleController@recycle',function($id,$recycle){})->where(['id'=>'[0-9]+','recycle'=>'[1,2]']);
	Route::get('listrecycle','ArticleController@listrecycle');
	Route::get('alldel','ArticleController@alldel');
	Route::post('remmend','ArticleController@remmend');
	Route::resource('article','ArticleController');
	Route::post('catestatus','CategoryController@status');
	Route::resource('category','CategoryController');
	Route::post('labelstatus','LabelController@status');
	Route::resource('label','LabelController');
	Route::resource("user","QquserController");
	Route::post('linkstatus','ExtendController@status');
	Route::resource("extend","ExtendController");
	Route::post("noticestatus","NoticeController@status");
	Route::resource("notice","NoticeController");
	Route::any("push","PushController@push");
	Route::post("albumstatus","AlbumController@status");
	Route::resource("album","AlbumController");
	Route::post("photostatus","PhotoController@status");
	Route::resource("photo","PhotoController");
	Route::post("linestatus","TimelineController@status");
	Route::resource("timeline","TimelineController");
});

Route::group(['namespace' => 'Home'],function(){
	Route::any('/','IndexController@index');
	Route::any("send","IndexController@send");
	Route::any("detail/id/{id}","DetailController@index",function($id){})->where(['id'=>'[0-9]+']);
	Route::any('about',"AboutController@index");
	Route::post("detail/comment/id/{id}","DetailController@comment",function($id){})->where(['id'=>'[0-9]+']);
	Route::post("about/message","AboutController@message");
	Route::any("article","ArticleController@index");
	Route::any("resource","ResourceController@index");
	Route::post("resourcedata/id/{id}","ResourceController@data",function($id){})->where(['id'=>'[0-9]+']);
	Route::any("timeline","TimelineController@index");
});

//Route::get('admin/index','Admin\IndexController@index')->name('admin');
