<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthRequest;
use App\Http\Requests\LoginAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function create(CreateAuthRequest $request)
    {
        try{
//            $validateUser= validator::make($request->all(),[
//                'name'=>'required',
//                'email'=>'required|email|unique:users,email',
//                'password'=>'required_with:password_confirmation|same:password_confirmation',
//                'password_confirmation'=>"",
//            ]);
//            if($validateUser->fails()) {
//                return response()->json([
//                    'status'=>false,
//                    'message'=>'validation error',
//                    'errors'=>$validateUser->errors()
//                ],401);
//            }
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'role'=>$request->role,
                'password'=>Hash::make($request->password),
            ]);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return redirect()->route('workplace');
        }catch (\Throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }
    public function login(LoginAuthRequest $request)
    {

        try{
//            $validateUser=validator::make($request->all(),[
//                'email'=>'required|email',
//                'password'=>'required'
//            ]);
//            if($validateUser->fails()){
//                return response()->json([
//                    'status' => false,
//                    'message'=> 'validation error',
//                    'errors'=>$validateUser->errors()
//                ],401);
//            }

            if(!Auth::attempt($request->only(['email','password']))){
                return Response()->json([
                    'status'=>false,
                    'message'=>'email & password does not match with our record'
                ],401);
            }
            $user=User::where('email',$request->email)->first();
            return redirect()->route('workplace');

        }catch (\Throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens->each(function ($token, $key) {
               $token->delete();
               Auth::logout();
             });
      return redirect('/login');
    }
}
