<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Product;

class Category extends Model
{
    //
    use Translatable;//trait for package translatable
    protected $guarded = [];//end guarded

    public $translatedAttributes = ['name'];
    
///realtions 1======>m
            //product=======> category

    public function product()
    {
        return $this->hasMany('App\Product','category_id');
    }

}//end model category
