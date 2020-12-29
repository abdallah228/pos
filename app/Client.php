<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class Client extends Model
{
   
    //
    protected $guarded = [];


  //casting


protected $casts = [
    'mobile' => 'array',
];


    ///relations client and order
     /////////////1======>m
     public function orders()
     {
        return $this->hasMany('App\Order','client_id');
     }




     /////accessors
     public function getNameAttribute($value)
     {
       return ucfirst($value);
     }//end of get name attributes
   
}
