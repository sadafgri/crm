<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Factor;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::view('/login', 'authorize.login')->name('login');

Route::view('/register', 'authorize.register')->name('register');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/workplace', function () {
        $customer_count=User::count();
        $factor_count=Factor::count();
        $order_count=Order::count();

$product_count=Product::count();
        return view('workplace',compact('customer_count','factor_count','order_count','product_count'));
    })->name('workplace');


//    Route::post('/users/prof', [UserController::class, 'editImage'])->name('users.editProfImage');

});

