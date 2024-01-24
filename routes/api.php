<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Factor;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum') ->get('/user' , function (Request $request) {
    return $request->user();
});

Route::post('/auth/register' , [AuthController::class , 'create']);
Route::post('/auth/login' , [AuthController::class , 'login']);
Route::get('/auth/logout/{id}' , [AuthController::class , 'logout']);

Route::middleware('auth:sanctum')->group(function () {

//Route::group(['middleware'=>'checkrole:admin'],function (){

    //users
    Route::get('/users/filter', [UserController::class, 'filter'])->middleware('permission:FilterUsers');
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:IndexUsers');
    Route::post('/users', [UserController::class, 'store'])->middleware('permission:StoreUsers');
    Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->middleware('permission:DestroyUsers');

    //factors
    Route::get('checks/filter', [\App\Http\Controllers\CheckController::class, 'filter'])->middleware('permission:FilterChecks');
    Route::get('/checks', [ \App\Http\Controllers\CheckController::class, 'index'])->middleware('permission:IndexChecks');
    Route::post('/checks', [\App\Http\Controllers\CheckController::class, 'store'])->middleware('permission:StoreChecks');
    Route::put('/checks/{id}', [\App\Http\Controllers\CheckController::class, 'update'])->middleware('permission:UpdateChecks');
    Route::post('/checks/{id}/delete', [\App\Http\Controllers\CheckController::class, 'destroy'])->middleware('permission:DestroyChecks');
//});
//    Route::group(['middleware'=>'checkrole:adminAndseller','prefix'=>'products'],function (){

        //products
        Route::get('products/filter', [ProductController::class, 'filter'])->middleware('permission:FilterProducts');
        Route::get('/products', [ProductController::class, 'index'])->middleware('permission:IndexProducts');
        Route::post('/products', [ProductController::class, 'store'])->middleware('permission:StoreProducts');
        Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('permission:UpdateProducts');
        Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])->middleware('permission:DestroyProducts');
//    });

//    Route::group(['middleware'=>'checkrole:adminAndcustomer' , 'prefix'=>'orders'],function (){

        //orders
        Route::get('orders/filter', [OrderController::class, 'filter'])->middleware('permission:FilterOrders');
        Route::get('/orders', [OrderController::class, 'index'])->middleware('permission:IndexOrders');
        Route::post('/orders', [OrderController::class, 'store'])->middleware('permission:StoreOrders');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->middleware('permission:UpdateOrders');
        Route::post('/orders/{id}/delete', [OrderController::class, 'destroy'])->middleware('permission:DestroyOrders');
//    });

    Route::post('/users/{id}', [UserController::class, 'update'])->middleware('permission:UpdateUsers');
    Route::get('/send',[\App\Http\Controllers\MailController::class,'index']);
});
