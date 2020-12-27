<?php


Route::group(['prefix' => LaravelLocalization::setLocale()], function(){//laravel localisation mcamara

Route::group(['prefix'=>'dashboard','namespace'=>'Dashboard','middleware'=>'auth'],function()
{

  route::get('/','DashboardController@index')->name('dashboard.index');



//categories route
route::resource('categories','CategoryController')->except(['show']);

//products route
route::resource('products','ProductController')->except(['show']);

//clients route
route::resource('clients','ClientController')->except(['show']);

//orders
route::resource('clients.orders', 'Client\OrderController')->except(['show']);



////users route////
route::resource('users','UserController')->except(['show']);
   
});
});

