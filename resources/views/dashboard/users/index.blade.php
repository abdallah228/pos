@extends('layouts.dashboard.app')
@section('content')



<div class="content-wrapper">
<section class="content-header">
<h1>
    {{__('site.users')}}
</h1>
<ol class="breadcrumb">
<li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i>{{__('site.dashboard')}}</a></li>
<li class="active"></i>{{__('site.users')}}</li>
</ol>

</section>

<section class="content">

<div class="box box-primary">
<div class="box-header with-border">
<h4 class="box-title" style="margin-bottom:15px;">{{__('site.users')}}<small>{{$users->total()}}</small></h4>

<form method="get" action="{{route('users.index')}}">
<div class="row">
<div class="col-md-4">
<input type ="text" name="search" class="form-control" placeholder="{{__('site.search')}}" value="{{request()->search}}">
</div>
<div class="col-md-4">
    <button type="submit" class="btn btn-primary" value=><i class="fa fa-search"></i>{{__('site.search')}}</button>
    @if(auth()->user()->hasPermission('create_users'))
    <a href="{{route('users.create')}}" class="btn btn-primary">{{__('site.add')}}</a>
    @else
    <a href="{{route('users.create')}}" class="btn btn-primary  disabled">{{__('site.add')}}</a>
    @endif
</div>

</div><!-- end div row-->
</form><!--end form-->


</div><!--end of box header-->

<div class="box-body">
@if($users->count() > 0)
<table class="table table-hover" >
<thead>
<tr>
<th>#</th>
<th>{{__('site.first_name')}}</th>
<th>{{__('site.last_name')}}</th>
<th>{{__('site.email')}}</th>
<th>{{__('site.image')}}</th>
<th>{{__('site.action')}}</th>
</tr>
</thead>
<tbody>
@foreach($users as $index=>$user)
<tr>
<td>{{$index+1}}</td>
<td>{{$user->first_name}}</td>
<td>{{$user->last_name}}</td>
<td>{{$user->email}}</td>
<td><img src="{{asset('uploads/users_image/'.$user->image)}}" width="100px" class="img-thumbnail"></td>
<td>
@if(auth()->user()->hasPermission('update_users'))
<a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
@else
<a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
@endif

@if(auth()->user()->id == $user->id)
<button type="submit" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i> {{__('site.delete')}}</button>
@else
@if(auth()->user()->hasPermission('delete_users'))
<form action="{{route('users.destroy',$user->id)}}" method="post"style="display:inline-block;">
@csrf
@method('delete')
<button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> {{__('site.delete')}}</button>
@else
<button type="submit" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> {{__('site.delete')}}</button>
@endif
@endif
</form>
</td>
</tr>
@endforeach
</tbody>
</table><!-- end table -->
{{$users->appends(request()->query())->links()}}
@else
{{__('site.no_data_found')}}
@endif

</div><!--end of box body-->
</div><!-- end of box-->

</section>

</div>




@endsection