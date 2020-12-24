@extends('layouts.dashboard.app')
@section('content')



<div class="content-wrapper">
<section class="content-header">
<h1>
    {{__('site.products')}}
</h1>
<ol class="breadcrumb">
<li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>{{__('site.dashboard')}}</a></li>
<li class="active"></i>{{__('site.products')}}</li>
</ol>

</section>

<section class="content">

<div class="box box-primary">
<div class="box-header with-border">
<h4 class="box-title" style="margin-bottom:15px;">{{__('site.products')}}<small>{{$products->total()}}</small></h4>

<form method="get" action="{{route('products.index')}}">
<div class="row">
<div class="col-md-4">
<input type ="text" name="search" class="form-control" placeholder="{{__('site.search')}}" value="{{request()->search}}">
</div>
<div class="col-md-4">
<select name="category_id" class="form-control">
    <option>{{__('site.all_categories')}}</option>
@foreach($categories as $category)
    <option value="{{$category->id}}" {{request()->category_id == $category->id ?'selected' : ''}}>{{$category->name}}</option>
    @endforeach
</select>
</div>
<div class="col-md-4">
    <button type="submit" class="btn btn-primary" value=><i class="fa fa-search"></i>{{__('site.search')}}</button>
    @if(auth()->user()->hasPermission('create_products'))
    <a href="{{route('products.create')}}" class="btn btn-primary">{{__('site.add')}}</a>
    @else
    <a href="{{route('products.create')}}" class="btn btn-primary  disabled">{{__('site.add')}}</a>
    @endif
</div>

</div><!-- end div row-->
</form><!--end form-->


</div><!--end of box header-->

<div class="box-body">
@if($products->count() > 0)
<table class="table table-hover" >
<thead>
<tr>
<th>#</th>
<th>{{__('site.product_name')}}</th>
<th>{{__('site.product_description')}}</th>
<th>{{__('site.category_name')}}</th>
<th>{{__('site.product_image')}}</th>
<th>{{__('site.purchase_price')}}</th>
<th>{{__('site.sale_price')}}</th>
<th>{{__('site.profit_percentage')}} %</th>
<th>{{__('site.stock')}}</th>
<th>{{__('site.action')}}</th>
</tr>
</thead>
<tbody>
@foreach($products as $index=>$product)
<tr>
<td>{{$index+1}}</td>
<td>{{$product->name}}</td>
<td>{!!$product->description!!}</td>
<td>{{$product->category->name}}</td>
<td><img src="{{asset('uploads/products_image/'.$product->image)}}"  class="img-thumbnail" style="height:100px; width:100px" ></td>
<td>{{$product->purchase_price}}</td>
<td>{{$product->sale_price}}</td>
<td>{{$product->profit_percentage}} %</td>
<td>{{$product->stock}}</td>
<td>
@if(auth()->user()->hasPermission('update_categories'))
<a href="{{route('products.edit',$product->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
@else
<a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
@endif

@if(auth()->user()->hasPermission('delete_products'))
<form action="{{route('products.destroy',$product->id)}}" method="post"style="display:inline-block;">
@csrf
@method('delete')
<button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> {{__('site.delete')}}</button>
@else
<button type="submit" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> {{__('site.delete')}}</button>
@endif

</form>
</td>
</tr>
@endforeach
</tbody>
</table><!-- end table -->
{{$products->appends(request()->query())->links()}}
@else
{{__('site.no_data_found')}}
@endif

</div><!--end of box body-->
</div><!-- end of box-->

</section>

</div>




@endsection