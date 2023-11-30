<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create()
    {
     return view("users.addUser");
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_number'=>'required',
            'age'=>'required',
            'email'=>'required|email|uniqe:users',
            'address'=>'required',
            'postal_code'=>'required',
            'country'=>'required',
            'city'=>'required',
            'province'=>'required',
            'password'=>'required',
            'gender'=>'required',
        ]);
        DB::table('users')->insert([
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
            'created_at'=>date('Y_m_d_H:i:s'),
            'password'=>md5($request->password),
            'gender'=>$request->gender,
        ]);
        return redirect()->route('users.index');
    }

    public function index()
    {
      $users = DB::table('users')->get();
      return view("users.usersData",['users'=>$users]);
    }

    public function edit($id)
    {
        $users = DB::table('users')->where('id',$id)->first();
        return view("users.editUser",['user'=>$users]);
    }

    public function update()
    {

    }
}
