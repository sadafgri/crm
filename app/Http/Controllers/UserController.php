<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeUserRequest;
use App\Http\Requests\updateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
//    public function create()
//    {
//        return view("users.addUser");
//    }

    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'users retrieved successfully',
            'data' => $users
        ]);
    }
    public function store(storeUserRequest $request)
    {

       $users = User::create([

            'user_name' => $request->user_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'age' => $request->age,
            'email' => $request->email,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'city' => $request->city,
            'province' => $request->province,
            'password' => md5($request->password),
            'gender' => $request->gender,
        ]);
        $users->addMediaFromRequest('image')->toMediaCollection();

        return response()->json([
            'message' => 'user created successfully',
            'data' => $users
        ], 201);    }

//    public function edit($id)
//    {
//        $users = User::find($id);
//        if (!$users) {
//            return response()->json([
//                'status' => false,
//                'message' => 'user not found'
//            ], 404);
//        }
//        return response()->json([
//            'status' => true,
//            'message' => 'user retrieved successfully',
//            'data' => $users
//        ],);
//    }
    public function update(updateUserRequest $request, $id)
    {
        $users = User::where('id', $id)->update([
            'user_name' => $request->user_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'age' => $request->age,
            'email' => $request->email,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'city' => $request->city,
            'province' => $request->province,
            'gender' => $request->gender,
        ]);
        $user = User::find($id);
        $user->addMediaFromRequest('image')->toMediaCollection();

        if (auth()->user()->role == 'admin') {
            return response()->json([
                'status' => true,
                'message' => 'user updated successfully',
                'data' => User::find($id)
            ], 200);
//            return redirect()->route('users.index');
//        }else{
//            return redirect()->route('workplace');
//        }
        }
    }
    public function destroy($id)
    {
        User::where('id',$id)->update(['status'=>'disable']);
        return response()->json([
            'status' => true,
            'message' => 'user delete successfully'
        ], 200);
    }

    public function filter(Request $request)
    {
//        estefade az if
        $users = User::all();

        if ($request->filterEmail) {
            $users = $users->where('email', $request->filterEmail);
        }
        if ($request->filterFirstName) {
            $users = $users->where('first_name', $request->filterFirstName);
        }
        if ($request->filterLastName) {
            $users = $users->where('last_name', $request->filterLastName);
        }
        if ($request->filterUserName) {
            $users = $users->where('user_name', $request->filterUserName);
        }
        if ($request->filterPhoneNumber) {
            $users = $users->where('phone_number', $request->filterUserName);
        }
        if ($request->filterAgeMin && $request->filterAgeMax) {
            $users = $users->whereBetween('age', [$request->filterAgeMin, $request->filterAgeMax]);
        }
        if ($request->filterGender) {
            $users = $users->where('gender', $request->filterGender);
        }
        if ($request->filterPostalCode) {
            $users = $users->where('postal_code', $request->filterPostalCode);
        }

        $query = [];
        if ($request->filterOrderStatus) {
            if ($request->filterOrderStatus == 'true') {
                foreach ($users as $user) {
                    if ($user->orders->count()) {
                        $query[] = $user->id;
                    }
                }
            }
        }
        if ($request->filterOrderStatus == 'false') {
            foreach ($users as $user) {
                if (!$user->orders->count()) {
                    $query[] = $user->id;
                }
             }
            $users = $users->find($query);
        }
            if($request->filterRole ==  'customer' ){
                $users = $users->where('role','customer');
            }
            if($request->filterRole == 'seller'){
                $users = $users->where('role','seller');
            }

            return response()->json([
                'status' => true,
                'message' => 'users filtered successfully',
                'data' => $users
            ]);
//        estefade az package
//        $minAgeFilter = AllowedFilter::callback('AgeMin', function ($query, $value) {
//            $query->where('age', '>=', $value);
//        });
//        $maxAgeFilter = AllowedFilter::callback('AgeMax', function ($query, $value) {
//            $query->where('age', '<=', $value);
//        });
//        $users = QueryBuilder::for(User::class)
//            ->allowedIncludes(['orders'])
//            ->allowedFilters([
//                 $minAgeFilter, $maxAgeFilter,
//            AllowedFilter::exact('email')->ignore(null),
//            AllowedFilter::exact('first_name')->ignore(null),
//            AllowedFilter::exact('last_name')->ignore(null),
//            AllowedFilter::exact('user_name')->ignore(null),
//            AllowedFilter::exact('gender')->ignore(null),
//            AllowedFilter::exact('phone_number')->ignore(null),
//            AllowedFilter::exact('postal_code')->ignore(null),
//        ])->get();
//
//        return view("users.usersData", ['users' => $users]);
        }
}

