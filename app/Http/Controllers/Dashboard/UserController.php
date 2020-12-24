<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
//use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


//use Intervention\Image\Facades\Image;


class UserController extends Controller
{
    
    
     //middleware permission
     public function __construct()
     {
         //crud
          $this->middleware(['permission:read_users'])->only('index');
          $this->middleware(['permission:create_users'])->only('create');
          $this->middleware(['permission:update_users'])->only('edit');
          $this->middleware(['permission:read_users'])->only('destroy');
     }


    public function index(Request $request)
    {

        //
     /*  if($request->search)//=>way of search
        {
            $users = User::where('first_name' , 'like' , '%' .$request->search . '%')
            ->orWhere('last_name','like','%' .$request->search . '%')->latest()->paginate(3);
        }
        else
        {
        $users = User::whereRoleIs('admin')->paginate(3);//find role has admin
        }
        */
        //another way

        $users = User::whereRoleIs('admin')->when($request->search, function($query) use ($request){
                return $query->where('first_name' , 'like' , '%' .$request->search . '%')
                ->orWhere('last_name','like','%' .$request->search . '%');
        })->latest()->paginate(5);


        return view('dashboard.users.index',compact('users'));
    }

    
    public function create()
    {
        //
        return view('dashboard.users.create');
    }

  
    public function store(StoreUserRequest $request)
    {
        //dd($request->all());
        //validation done

        //store
        $request_data = $request->except(['password','password_confirmation','permissions','image']);
        $request_data['password'] = bcrypt($request->password);
        if($request->image)
        {
            $image = Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path("uploads/users_image/".$request->image->hashName()));
            
            $request_data['image']  = $request->image->hashName();

        }//end if
        $user = User::create($request_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        return redirect()->route('users.index')->with(["success"=>__('site.added_success')]);
      
    }

    
    public function edit(User $user)
    {
        //
        return view('dashboard.users.edit',compact('user'));
    }

    
    public function update(Request $request, User $user)
    {
        //validation
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            //'image'=>'image',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'permissions'=>'required',
        ]);
        $request_data = $request->except(['permissions','image']);
        if($request->image){
            if($user->image != 'default.jpg'){
            $u = storage::disk('public_uploads')->delete($user->image);
        } //end internal
        $image = Image::make($request->image)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path("uploads/users_image/".$request->image->hashName()));
        
        $request_data['image']  = $request->image->hashName();
}//end external if
        $user->update($request_data);
        $user->syncPermissions($request->permissions);
        return redirect()->route('users.index')->with(["success"=>__('site.update_success')]);

    
    }
  
    public function destroy(User $user)
    {
        //
        if($user->image != 'default.jpg')
        {
            $u = storage::disk('public_uploads')->delete($user->image);

        }
       // $user->findOrFail($user);
        $user->delete();
        return redirect()->back()->with(['success'=>__('site.delete_succes')]);
       
    }
}
