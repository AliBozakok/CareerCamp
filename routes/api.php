<?php

use App\Http\Controllers\categoryController;
use App\Http\Controllers\productController;
use App\Http\Controllers\userController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category', [categoryController::class,'index']);
Route::get('category/{id}', [categoryController::class,'show']);
Route::post('category', [categoryController::class,'store']);
Route::put('category/{id}', [categoryController::class,'update']);
Route::delete('category/{id}', [categoryController::class,'destroy']);
Route::apiResource('product', productController::class);


Route::post('register', [userController::class,'register']);
Route::post('login', [userController::class,'login']);
Route::group([

    'middleware' => 'auth:user',
    'prefix' => 'auth'

], function ($router) {


    Route::get('logout', [userController::class,'logout']);
    Route::get('me', [userController::class,'me']);

});
