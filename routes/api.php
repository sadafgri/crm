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
    Route::get('/users/filter', [UserController::class, 'filter']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/users/{id}/delete', [UserController::class, 'destroy']);

    //factors
    Route::get('checks/filter', [\App\Http\Controllers\CheckController::class, 'filter']);
    Route::get('/checks', [ \App\Http\Controllers\CheckController::class, 'index']);
    Route::post('/checks', [\App\Http\Controllers\CheckController::class, 'store']);
    Route::put('/checks/{id}', [\App\Http\Controllers\CheckController::class, 'update']);
    Route::post('/checks/{id}/delete', [\App\Http\Controllers\CheckController::class, 'destroy']);
//});
    Route::group(['middleware'=>'checkrole:adminAndseller','prefix'=>'products'],function (){

        //products
        Route::get('/filter', [ProductController::class, 'filter']);
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::post('/{id}/delete', [ProductController::class, 'destroy']);
    });

    Route::group(['middleware'=>'checkrole:adminAndcustomer' , 'prefix'=>'orders'],function (){

        //orders
        Route::get('/filter', [OrderController::class, 'filter']);
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::put('/{id}', [OrderController::class, 'update']);
        Route::post('/{id}/delete', [OrderController::class, 'destroy']);
    });

    Route::post('/users/{id}', [UserController::class, 'update']);
});
