<?php


Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
Route::group(['prefix'=>'dashboard','namespace'=>'Dashboard','middleware'=>'auth'],function()
{

  route::get('/index','DashboardController@index')->name('dashboard.index');

////users route////
route::resource('users','UserController')->except(['show']);

//categories route
route::resource('categories','CategoryController')->except(['show']);

//products route
route::resource('products','ProductController')->except(['show']);
   
});
});

