@extends('layouts.dashboard.app')
@section('content')


<div class="content-wrapper">
<section class="content-header">
<h1>
    {{__('site.products')}}
</h1>
<ol class="breadcrumb">
<li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>{{__('site.dashboard')}}</a></li>
<li><a href="{{route('categories.index')}}"></i>{{__('site.products')}}</a></li>
<li class="active "></i>{{__('site.add')}}</li></ol>
</sectin>

<section class="content">


<div class="box box-primary">
<div class="box box-header">

<h3 class="cox-title">{{__('site.add')}}</h3>

</div><!--end of box header-->

<div class="box-body">
<form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
@csrf
@method('post')


<div class="form-group">
<label>{{__('site.categories')}}</label>
<select name="category_id" class="form-control">
    <option >{{__('site.all_categories')}}</option>
    @foreach($categories as $category)
    <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
    @endforeach
</select>
@if ($errors->has('category_id'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('category_id') }}</strong>
</span>
@endif
</div>





@foreach(config('translatable.locales') as $locale)
<div class="form-group">
<label>{{__('site.'.$locale  . '.product_name')}}</label>
<input type="text" name="{{$locale}}[name]" class="form-control" value="{{old($locale .'.name')}}" placeholder="{{__('site.product_name')}}">
</div>
@if ($errors->has($locale .'.name'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first($locale . '.name') }}</strong>
</span>
@endif

<div class="form-group">
<label>{{__('site.'.$locale  . '.product_description')}}</label>
<textarea  name="{{$locale}}[description]" class="form-control ckeditor" placeholder="{{__('site.product_description')}}">{{old($locale .'.name')}}</textarea>
</div>
@if ($errors->has($locale .'.description'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first($locale . '.description') }}</strong>
</span>
@endif
@endforeach

<div class="form-group">
<label>{{__('site.image')}}</label>
<input type="file" name="image" class="form-control image"  >
@if ($errors->has('image'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('image') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<img src="{{asset('uploads/products_image/'.'default.jpg')}}" width="100px" class="img-thumbnail image-preview">
</div>



<div class="form-group">
<label>{{__('site.purchase_price')}}</label>
<input type="number" name="purchase_price" class="form-control"  >
@if ($errors->has('purchase_price'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('purchase_price') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<label>{{__('site.sale_price')}}</label>
<input type="number" name="sale_price" class="form-control" >
@if ($errors->has('sale_price'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('sale_price') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<label>{{__('site.stock')}}</label>
<input type="number" name="stock" class="form-control" >
@if ($errors->has('stock'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('stock') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i>{{__('site.add')}}</button>
</div>
</form>

</div><!--end of box body-->


</div><!-- end of box-->

</section>


</div>






@stop