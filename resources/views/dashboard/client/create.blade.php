@extends('layouts.dashboard.app')
@section('content')


<div class="content-wrapper">
<section class="content-header">
<h1>
    {{__('site.clients')}}
</h1>
<ol class="breadcrumb">
<li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>{{__('site.dashboard')}}</a></li>
<li><a href="{{route('clients.index')}}"></i>{{__('site.clients')}}</a></li>
<li class="active "></i>{{__('site.add')}}</li></ol>
</sectin>

<section class="content">


<div class="box box-primary">
<div class="box box-header">

<h3 class="cox-title">{{__('site.add')}}</h3>

</div><!--end of box header-->

<div class="box-body">
<form action="{{route('clients.store')}}" method="post">
@csrf
@method('post')

<div class="form-group">
<label>{{__('site.clients_name')}}</label>
<input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="{{__('site.clients_name')}}">
@if ($errors->has('name'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('name') }}</strong>
</span>
@endif
</div>

@for($i = 0 ; $i < 2 ; $i++ )

<div class="form-group">
<label>{{__('site.clients_mobile')}}{{$i+1}}</label>
<input type="text" name="mobile[]" class="form-control" placeholder="{{__('site.clients_mobile')}}" >
@if ($errors->has('mobile'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('mobile') }}</strong>
</span>
@endif
</div>
@endfor

<div class="form-group">
<label>{{__('site.clients_address')}}</label>
<input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="{{__('site.clients_address')}}">
@if ($errors->has('address'))
<span class="invalid-feedback btn-danger" role="alert">
<strong>{{ $errors->first('address') }}</strong>
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