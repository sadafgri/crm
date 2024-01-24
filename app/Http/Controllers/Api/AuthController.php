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
            $user = User::create([
                'user_name'=>$request->name,
                'email'=>$request->email,
                'role'=>$request->role,
                'password'=>Hash::make($request->password),
            ]);
            $user->assignRole($request->role);

//            if ($user->role == 'seller'){
//                $user->assignRole('seller');
//            }
//            if($user->role =='customer'){
//                $user->assignRole('customer');
//            }

          $token =  $user->createToken("API TOKEN")->plainTextToken;

            return Response()->json([
                'status'=>true,
                'message'=>'register successfully',
                'token'=>$token
            ],200);
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
           $user= User::where('email',$request->email)->first();
//            session()->put('token',$user->createToken("API TOKEN")->plainTextToken);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return Response()->json([
                'status'=>true,
                'message'=>'login successfully',
                'token'=>$token
            ],200);

        }catch (\Throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

    public function logout($id)
    {
        $user = User::find($id);
        $user->tokens->each(function ($token, $key) {
               $token->delete();
               Auth::logout();
             });
        return Response()->json([
            'status'=>true,
            'message'=>'logout successfully'
        ],200);
    }
}
