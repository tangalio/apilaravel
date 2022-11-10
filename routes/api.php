<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SizeController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\InvoiceDetailController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderDetailController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {

    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    // Category
    Route::get('view-category', [CategoryController::class, 'index']);
    Route::post('store-category', [CategoryController::class, 'store']);
    Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    Route::put('update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);
    Route::get('all-category', [CategoryController::class, 'allcategory']);

    // Products
    Route::post('store-product', [ProductController::class, 'store']);
    Route::get('view-product/{id?}', [ProductController::class, 'index']);
    Route::get('edit-product/{id}', [ProductController::class, 'edit']);
    Route::post('update-product/{id}', [ProductController::class, 'update']);
    Route::delete('delete-product/{id}', [ProductController::class, 'destroy']);

    // Size
    Route::get('view-size', [SizeController::class, 'index']);
    Route::post('store-size', [SizeController::class, 'store']);
    Route::get('edit-size/{id}', [SizeController::class, 'edit']);
    Route::put('update-size/{id}', [SizeController::class, 'update']);
    Route::delete('delete-size/{id}', [SizeController::class, 'destroy']);

    // Color
    Route::get('view-color', [ColorController::class, 'index']);
    Route::post('store-color', [ColorController::class, 'store']);
    Route::get('edit-color/{id}', [ColorController::class, 'edit']);
    Route::post('update-color/{id}', [ColorController::class, 'update']);
    Route::delete('delete-color/{id}', [ColorController::class, 'destroy']);

    // Order
    Route::get('view-order', [OrderController::class, 'index']);
    //Route::post('store-order', [OrderController::class, 'store']);
    Route::post('update-order/{id}', [OrderController::class, 'update']);
    Route::delete('delete-order/{id}', [OrderController::class, 'destroy']);

    // OrderDetail
    Route::get('view-orderdetail', [OrderDetailController::class, 'index']);
    Route::post('store-orderdetail', [OrderDetailController::class, 'store']);
    Route::post('update-orderdetail/{id}', [OrderDetailController::class, 'update']);
    Route::delete('delete-orderdetail/{id}', [OrderDetailController::class, 'destroy']);

    // Invoice
    Route::get('view-invoice', [InvoiceController::class, 'index']);
    Route::post('store-invoice', [InvoiceController::class, 'store']);
    Route::post('update-invoice/{id}', [InvoiceController::class, 'update']);
    Route::post('delete-invoice/{id}', [InvoiceController::class, 'destroy']);
    
    // Invoice Detail
    Route::get('view-invoicedetail', [InvoiceDetailController::class, 'index']);
    Route::post('store-invoicedetail', [InvoiceDetailController::class, 'store']);
    Route::post('update-invoicedetail/{id}', [InvoiceDetailController::class, 'update']);
    Route::post('delete-invoicedetail/{id}', [InvoiceDetailController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    //Cart
    Route::post('store-cart', [CartController::class, 'store']);
    Route::get('view-cart', [CartController::class, 'index']);
    Route::post('update-cart/{id}', [CartController::class, 'update']);
    Route::delete('delete-cart/{id}', [CartController::class, 'destroy']);

    //Order
    //Route::post('store-order', [OrderController::class, 'store']);

    //Logout
    Route::post('logout', [AuthController::class, 'logout']);
    

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
