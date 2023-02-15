<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\KioskController;
use App\Http\Controllers\Api\OutletLocationController;
use App\Http\Controllers\Api\BrandController;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CustomerFeedbackController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\StockController;

use App\Http\Controllers\Api\TopProductController;
use App\Http\Controllers\Api\LowInventoryController;
use App\Http\Controllers\Api\SalesHistoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('user', UserController::class);
// Route::post('kiosk/login', [UserController::class, 'login']);
// Route::apiResource('city', CityController::class);
// Route::apiResource('kiosk', KioskController::class);
// Route::get('kiosk/by-city-id/{id}', [KioskController::class, 'byCityId']);
// Route::apiResource('outlet-location', OutletLocationController::class);
// Route::apiResource('brand', BrandController::class);


// General API 
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('login_verified', [LoginController::class, 'login_verified']);
Route::post('user_list', [UserController::class, 'user_list']);
Route::post('city_list', [CityController::class, 'city_list']);
Route::post('kiosk_list', [KioskController::class, 'kiosk_list']);
Route::post('kiosk_list_by_city', [KioskController::class, 'kiosk_list_by_city']);
Route::post('outlet_location_list', [OutletLocationController::class, 'outlet_location_list']);
Route::post('brand_list', [BrandController::class, 'brand_list']);
Route::post('product_list', [ProductController::class, 'product_list']);
Route::post('addToCart', [CartController::class, 'addToCart']);
Route::post('getCartList', [CartController::class, 'getCartList']);
Route::post('removeItem', [CartController::class, 'removeItem']);
Route::post('create_order', [OrderController::class, 'create_order']);
Route::post('upload_order_receipt', [OrderController::class, 'upload_order_receipt']);
Route::post('feedback_question_list', [FaqController::class, 'feedback_question_list']);
Route::post('customer_feedback', [CustomerFeedbackController::class, 'customer_feedback']);
Route::post('stock_list', [StockController::class, 'stock_list']);
Route::post('requested_qty_update', [StockController::class, 'requested_qty_update']);

Route::post('top_products', [TopProductController::class, 'top_products']);
Route::post('low_inventory', [LowInventoryController::class, 'low_inventory']);
Route::post('sales_history', [SalesHistoryController::class, 'sales_history']);

