<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //



        $products = ['product1','product2'];

        foreach($products as $product)
        Product::create([
            'category_id'=>1,
            'ar'=>['name'=>$product , 'description'=>$product . 'desc'],
            'en'=>['name'=>$product, 'description'=>$product . 'desc'],
            'purchase_price'=>100 ,
            'sale_price'=>150 ,
            'stock'=>100,






        ]);
    }
}
