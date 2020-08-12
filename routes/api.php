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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });





Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::post('/logout', 'AuthController@logout');
    Route::apiResource('products', 'ProductController')
        ->only(['index','show','store','update','destroy']);
    Route::apiResource('transactions', 'TransactionController')
        ->only(['index','show','store','update','destroy']);
    Route::apiResource('transaction-item', 'TransactionItemController')
        ->only(['index','show','store','update','destroy']);
    Route::apiResource('users', 'UserController')
        ->only(['index','show','store','update','destroy']);
});
