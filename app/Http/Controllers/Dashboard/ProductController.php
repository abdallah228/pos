<?php

namespace App\Http\Controllers\Dashboard;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $products = Product::when($request->search , function($q) use($request){
            return $q->whereTranslationLike('name', '%'.$request->search. '%');
        })->when($request->category_id , function($query) use($request){
            return $query->where('category_id',$request->category_id);

        })->latest()->paginate(5); 
        $categories = Category::all();
        //$products = Product::paginate(5);
        return view('dashboard.product.index',compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('dashboard.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $roles = [
            'category_id'=>'required',
        ];
        foreach(config('translatable.locales') as $locale)
        {
            $roles += [$locale. '.name'=>'required|unique:product_translations,name'];
            $roles += [$locale. '.description'=>'required' ];
        }
        $roles += ['purchase_price'=>'required',
                    'sale_price'=>'required',
                    'stock'=>'required',
    ];
    $request->validate($roles);//end validation
     //store
     $request_data = $request->except(['image']);
     if($request->image)
     {
        //$img = Image::make($request->file('photo')->getRealPath());

         $image = Image::make($request->image)->resize(300, null, function ($constraint) {
             $constraint->aspectRatio();
         })->save(public_path("uploads/products_image/".$request->image->hashName()));
         
         $request_data['image']  = $request->image->hashName();

     }//end if
     $product = Product::create($request_data);//save data
     return redirect()->route('products.index')->with(["success"=>__('site.added_success')]);
                                                    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $categories = Category::all();
        return view('dashboard.product.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $roles = [
            'category_id'=>'required',
        ];
        foreach(config('translatable.locales') as $locale)
        {
            $roles += [$locale. '.name'=>['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
            $roles += [$locale. '.description'=>'required' ];
        }
        $roles += ['purchase_price'=>'required',
                    'sale_price'=>'required',
                    'stock'=>'required',
    ];
    $request->validate($roles);//end validation
    $request_data = $request->except(['image']);
    if($request->image){
        if($product->image != 'default.jpg'){
        $u = storage::disk('public_uploads_products')->delete($product->image);
    } //end internal
    $image = Image::make($request->image)->resize(300, null, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path("uploads/products_image/".$request->image->hashName()));
    
    $request_data['image']  = $request->image->hashName();
}//end external if
        $product->update($request_data);
        return redirect()->route('products.index')->with(["success"=>__('site.update_success')]);


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        if($product->image != 'default.jpg')
        {
            $product = storage::disk('public_uploads_products')->delete($product->image);
        }
        return redirect()->back()->with(['success'=>__('site.delete_succes')]);

    }
}
