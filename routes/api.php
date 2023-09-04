<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DelivererController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\DelivererAuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;

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



 Route::post('/register',[AuthController::class,'register']);
 Route::put('/verification',[AuthController::class,'verification']);
 Route::post('/signin',[AuthController::class,'signin']);

 Route::post('/customers/create', [CustomerController::class,'create']);
 Route::get('/customers/getAll', [CustomerController::class,'index']);
 Route::get('/customers/get/{id}',[CustomerController::class,'show']);
 Route::put('/customers/edit/{id}',[CustomerController::class,'edit']);
 Route::delete('/customers/delete/{id}',[CustomerController::class,'destroy']);
 Route::middleware(['role:customer'])->get('/customers/myOrders',[CustomerController::class,'myOrders']);

 Route::middleware(['role:restaurant'])->post('/offers/create',[OfferController::class,'create']);
 Route::put('/offers/edit/{id}',[OfferController::class,'edit']);

 Route::middleware(['role:customer'])->post('/orders/create',[OrderController::class,'create']);

 Route::get('send-mail', [MailController::class, 'index']);

 Route::middleware(['role:restaurant'])->get('/restaurants/myMeals', [RestaurantController::class,'myMeals']);
 Route::post('/restaurants/create',[RestaurantController::class,'create']);
 Route::get('/restaurants/{id}',[RestaurantController::class,'show']);
 Route::get('/restaurants',[RestaurantController::class,'index']);
 Route::post('/restaurants/{id}',[RestaurantController::class,'edit']);
 Route::delete('/restaurants/{id}',[RestaurantController::class,'destroy']);
 Route::middleware(['role:restaurant'])->post('/meals/create', [MealController::class,'create']);

 Route::middleware(['role:deliverer'])->get('/deliverers/myOrders',[DelivererController::class,'myOrders']);

 Route::post('/deliverer/create',[DelivererController::class,'create']);
 Route::post('/deliverer/edit/{id}',[DelivererController::class,'edit']);
 Route::middleware(['role:deliverer'])->get('/deliverer/{id}', [DelivererController::class,'show']);
 Route::get('/deliverer',[DelivererController::class,'index']);

 Route::middleware(['role:customer'])->get('/orders/myOffers/{id}', [OrderController::class,'myOffers']);
 Route::middleware(['role:customer'])->get('/orders/myMeals/{id}', [OrderController::class,'mymeals']);
//  Route::post('meals/create',[MealController::class,'create']);
