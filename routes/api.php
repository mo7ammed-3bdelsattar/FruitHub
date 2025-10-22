<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\OrderTrakingController;

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

##--------------------------------------------------- AUTH MODULE
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});



##--------------------------------------------------- USERS MODULE
Route::get('users', [UserController::class,'index'])->middleware('auth.admin');
Route::get('profile', [UserController::class,'show'])->middleware('auth:sanctum');


##--------------------------------------------------- SETTINGS MODULE
Route::get('settings', SettingController::class);


##--------------------------------------------------- CITIES MODULE
Route::get('cities', CityController::class);


##--------------------------------------------------- CATEGORIES MODULE
Route::get('categories', CategoryController::class);


##--------------------------------------------------- TAGS MODULE
Route::get('tags', TagController::class);


##--------------------------------------------------- DRIVERS MODULE
Route::get('drivers', DriverController::class);


##--------------------------------------------------- PRODUCTS MODULE
Route::prefix('products')->controller(ProductController::class)->group(function(){
   Route::get('/','index');
   Route::get('/latest','latest');
   Route::get('/{id}','show');
});


##--------------------------------------------------- ORDERS MODULE
Route::prefix('orders')->middleware('auth:sanctum')->controller(OrderController::class)->group(function(){
   Route::get('/','index');
   Route::post('/','store');
   Route::get('/{id}','show');      
   Route::patch('/{id}','cancel');      
});
Route::get('orders/track/{id}',OrderTrakingController::class)->middleware('auth:sanctum');


##--------------------------------------------------- WISHLIST MODULE
Route::prefix('wishlist')->middleware('auth:sanctum')->controller(WishlistController::class)->group(function(){
   Route::get('/','index');
   Route::post('/{id}','store');
   Route::delete('/{id}','destroy');
});


##--------------------------------------------------- CARTS MODULE
Route::apiResource('cart',CartController::class)->middleware('auth:sanctum');


##--------------------------------------------------- ADDRESSES MODULE
Route::apiResource('address',AddressController::class)->middleware('auth:sanctum');
Route::get('users/{id}/addresses',[ AddressController::class,'getUserAddresses'])->middleware('auth.admin');
        