<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        //
        $categories =Category::when($request->search , function($q) use($request) {
            return $q->whereTranslationLike('name', '%'.$request->search.'%');
        })->latest()->paginate(5);
        return view('dashboard.category.index',compact('categories'));
    }

   
    public function create()
    {
        //
        return view('dashboard.category.create');
    }

 
    public function store(Request $request)
    {
        //
        
        $roles =[];
        foreach(config('translatable.locales') as $locale)
        {
            $roles += [$locale . '.name'=>['required',Rule::unique('category_translations','name')]];
        }
        $request->validate($roles); 

        Category::create($request->all());
        return redirect()->route('categories.index')->with(['success'=>__('site.added_success')]);
    }

  
    public function edit(Category $category)
    {
        //

        return view('dashboard.category.edit',compact('category'));
    }

   
    public function update(Request $request, Category $category)
    {
        //
     
            $roles =[];
            foreach(config('translatable.locales') as $locale)
            {
                $roles += [$locale . '.name'=>['required',Rule::unique('category_translations','name')->ignore($category->id,'category_id')]];
            }

      $request->validate($roles); 
        $category->update($request->all());

        return redirect()->route('categories.index')->with(["success"=>__('site.update_success')]);



    }

    
    public function destroy(Category $category)
    {
        //
        
        $category->product()->delete();
        $category->delete();
        return redirect()->route('categories.index')->with(["success"=>__('site.delete_succes')]);

    }//end delete
}
