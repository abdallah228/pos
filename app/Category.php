<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    //
    use Translatable;//trait for package translatable
    protected $guarded = [];//end guarded

    public $translatedAttributes = ['name'];
    


}//end model category
