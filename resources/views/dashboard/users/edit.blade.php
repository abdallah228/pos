@extends('layouts.dashboard.app')
@section('content')


<div class="content-wrapper">
<section class="content-header">
<h1>
    {{__('site.users')}}
</h1>
<ol class="breadcrumb">
<li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>{{__('site.dashboard')}}</a></li>
<li><a href="{{route('users.index')}}"></i>{{__('site.users')}}</a></li>
<li class="active "></i>{{__('site.add')}}</li></ol>
</sectin>

<section class="content">


<div class="box box-primary">
<div class="box box-header">

<h3 class="cox-title">{{__('site.edit')}}</h3>

</div><!--end of box header-->

<div class="box-body">
<form action="{{route('users.update',$user->id)}}" method="post" enctype="multipart/form-data">
@csrf
@method('put')
<div class="form-group">
<label>{{__('site.first_name')}}</label>
<input type="text" name="first_name" class="form-control" value="{{$user->first_name}}">
@if ($errors->has('first_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('first_name') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<label>{{__('site.last_name')}}</label>
<input type="text" name="last_name" class="form-control" value="{{$user->last_name}}">
@if ($errors->has('last_name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('last_name') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<label>{{__('site.email')}}</label>
<input type="email" name="email" class="form-control" value="{{$user->email}}">
@if ($errors->has('email'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('email') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<label>{{__('site.image')}}</label>
<input type="file" name="image" class="form-control image" >
@if ($errors->has('image'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('image') }}</strong>
</span>
@endif
</div>

<div class="form-group">
<img src="{{asset('uploads/users_image/'.$user->image)}}" width="100px" class="img-thumbnail image-preview">
</div>




    <div class="form-group">
    <label>{{__('site.permessions')}} </label>
     <div class="nav-tabs-custome">
     
    @php
    $models = ['users','categories','products','clients','orders'];
    $maps = ['create','read','update','delete'];
    @endphp


     <ul class="nav nav-tabs">
     @foreach($models as $index=>$model)
    <li class="{{$index == 0 ? 'active' : ''}}"><a href="#{{$model}}" data-toggle="tab"> {{__('site.' . $model)}}</a></li>
    @endforeach
     </ul>

     <div class="tab-content">
    @foreach($models as $index=>$model)
    <div class="tab-pane {{$index == 0 ? 'active' : '' }}" id="{{$model}}">
    @foreach($maps as $map)
    <label><input type="checkbox" name="permissions[]" {{$user->hasPermission($map . '_' . $model) ? 'checked' : '' }}  value="{{$map . '_' . $model}}">{{__('site.'. $map)}}</label>
    @endforeach    
    </div>
    @endforeach
     </div><!-- end tab content-->

     
     </div> <!--end vav tabs--> 

    </div><!-- end form-group-->

<div class="form-group">
<button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i>{{__('site.update')}}</button>
</div>
</form>

</div><!--end of box body-->


</div><!-- end of box-->

</section>


</div>






@stop