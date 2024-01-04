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
Route::group(['middleware'=>'checkrole:admin'],function (){

    //users
    Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');

    //factors
    Route::get('/filter', [\App\Http\Controllers\CheckController::class, 'filter'])->name('checks.filter');
    Route::get('/checks', [ \App\Http\Controllers\CheckController::class, 'index'])->name('checks.index');
    Route::get('/checks/create',[\App\Http\Controllers\CheckController::class, 'create'])->name('checks.create');
    Route::post('/checks', [\App\Http\Controllers\CheckController::class, 'store'])->name('checks.store');
    Route::any('/checks/{id}/edit', [\App\Http\Controllers\CheckController::class, 'edit'])->name('checks.edit');
    Route::patch('/checks/{id}', [\App\Http\Controllers\CheckController::class, 'update'])->name('checks.update');
    Route::delete('/checks/{id}/delete', [\App\Http\Controllers\CheckController::class, 'destroy'])->name('checks.destroy');
});

    Route::group(['middleware'=>'checkrole:adminAndseller','prefix'=>'products'],function (){

        //products
        Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::post('/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::group(['middleware'=>'checkrole:adminAndcustomer' , 'prefix'=>'orders'],function (){

        //orders
        Route::get('/filter', [OrderController::class, 'filter'])->name('orders.filter');
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::any('/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::patch('/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/{id}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');

});

//login and register
    Route::post('/user/register',[\App\Http\Controllers\Api\AuthController::class,'create'])->name('user.register');
    Route::post('/user/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('user.login');
    Route::get('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');

