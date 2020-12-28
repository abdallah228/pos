<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

use App\Category;
use App\Product;

class Product extends Model
{
    use Translatable;//trait for package translatable
    protected $guarded = [];//end guarded

    public $translatedAttributes = ['name','description'];

    protected $appends = ['profit_percentage'];
    
    //reverse relation between category and product
    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }


    //profit attribute
    public function getProfitPercentageAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;
       $profit_percentage = $profit * 100 / $this->purchase_price;
       return number_format($profit_percentage,2);
    }

    
    ///m====>m order=====>product
    public function orders()
    {
        return $this->belongsToMany('App\Product','product_order');
    }
}
