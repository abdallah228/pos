@extends('layouts.dashboard.app')
@section('content')


<div class="content-wrapper">
<section class="content-header">
<h1>
    {{__('site.categories')}}
</h1>
<ol class="breadcrumb">
<li><a href="{{route('categories.index')}}"><i class="fa fa-dashboard"></i>{{__('site.categories')}}</a></li>
<li><a href="{{route('users.index')}}"></i>{{__('site.categories')}}</a></li>
<li class="active "></i>{{__('site.add')}}</li></ol>
</sectin>

<section class="content">


<div class="box box-primary">
<div class="box box-header">

<h3 class="cox-title">{{__('site.edit')}}</h3>

</div><!--end of box header-->

<div class="box-body">
<form action="{{route('categories.update',$category->id)}}" method="post" >
@csrf
@method('put')
@foreach(config('translatable.locales') as $locale)
<div class="form-group">
<label>{{__('site.'.$locale  . '.category_name')}}</label>
<input type="text" name="{{$locale}}[name]" class="form-control" value="{{$category->translate($locale)->name}}">
</div>
@if ($errors->has($locale .'.name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first($locale . '.name') }}</strong>
</span>
@endif
@endforeach

<div class="form-group">
<button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i>{{__('site.update')}}</button>
</div>
</form>

</div><!--end of box body-->


</div><!-- end of box-->

</section>


</div>






@stop