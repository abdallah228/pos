<?php

//for control lang
Route::group(['prefix' => LaravelLocalization::setLocale()], function(){//laravel localisation mcamara

Route::group(['prefix'=>'dashboard','namespace'=>'Dashboard','middleware'=>'auth'],function()
{
//dashboard and home
  route::get('/','DashboardController@index')->name('dashboard.index');


//categories route
route::resource('categories','CategoryController')->except(['show']);

//products route
route::resource('products','ProductController')->except(['show']);

//clients route && orders for client
route::resource('clients','ClientController')->except(['show']);
route::resource('clients.orders', 'Client\OrderController')->except(['show']);


//orders route
route::resource('orders','OrderController')->except(['show']);


////users route////
route::resource('users','UserController')->except(['show']);
   
});
});

