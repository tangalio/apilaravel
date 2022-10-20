<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'/user'],
function (){
    Route::get('/index/{id?}', [
        App\Http\Controllers\API\UserController::class, 'index']);

    //them
    Route::post('/store', [
        App\Http\Controllers\Api\UserController::class, 'store']);

    // //tim kiem
    // Route::get('/index/{id?}', [
    //     App\Http\Controllers\Api\CustomerController::class, 'show']);

    // //patch để cập nhật 1 vài trường
    // Route::patch('/update/{id?}', [
    //     App\Http\Controllers\Api\CustomerController::class, 'update']);

    // //xoa
    // Route::delete('/delete/{id?}', [
    //     App\Http\Controllers\Api\CustomerController::class, 'destroy']);
});
