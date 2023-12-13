<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeUserRequest;
use App\Http\Requests\updateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create()
    {
     return view("users.addUser");
    }
    public function index()
    {
        $users = User::all();
        return view("users.usersData",['users'=>$users]);
    }
    public function store(storeUserRequest $request)
    {
//        $imagename = $request->image->getClientOriginalName();
//        $request->image->move(public_path('image/users'),$imagename);

       User::create([
            'user_name'=>$request->user_name,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'phone_number'=>$request->phone_number,
            'age'=>$request->age,
            'email'=>$request->email,
            'address'=>$request->address,
            'postal_code'=>$request->postal_code,
            'country'=>$request->country,
            'city'=>$request->city,
            'province'=>$request->province,
            'password'=>md5($request->password),
            'gender'=>$request->gender,
        ]);
        return redirect()->route('users.index');
    }
    public function edit($id)
    {
        $users = User::find($id);
        return view("users.editUser",['user'=>$users]);
    }
    public function update(updateUserRequest $request,$id)
    {
        User::where('id',$id)->update([
          'user_name'=>$request->user_name,
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'phone_number'=>$request->phone_number,
        'age'=>$request->age,
        'email'=>$request->email,
        'address'=>$request->address,
        'postal_code'=>$request->postal_code,
        'country'=>$request->country,
        'city'=>$request->city,
        'province'=>$request->province,
        'gender'=>$request->gender,
    ]);
      return redirect()->route('users.index');
    }
    public function destroy($id)
    {
        User::where('id',$id)->update(['status'=>'disable']);
        return back();
    }
}
