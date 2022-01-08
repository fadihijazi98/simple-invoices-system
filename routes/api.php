<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::post('/store', function () {
    return [
        'store' => [
            'id' => 1,
            'name' => 'Store A',
            'created_at' => '2019',
            'updated_at' => '2019',
        ]
    ];
});

Route::post('/store/{store}/invoice', function ($store) {
    return [
        'invoice' => [
            'id' => 1,
            'customer_name' => 'Customer A',
            'status' => 2,
            'store_id' => $store,
            'created_at' => '2019',
            'updated_at' => '2019',
        ]
    ];
});

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
