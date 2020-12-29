<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Product;
use App\Client;

class Order extends Model
{
    //
    protected $guarded = [];

    //relations client===>order
    ////////////1======>m
    public function clients()
    {
        return $this->belongsTo('App\Client','client_id');
    }

    ///m====>m order=====>product
    public function products()
    {
        return $this->belongsToMany('App\Product','product_order')->withPivot('quantity');
    }
    
}
