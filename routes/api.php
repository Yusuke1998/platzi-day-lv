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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    
    Route::get('/', function () {
        return response()->json([
            'message' => 'Welcome to the Todo API',
            'status' => 'Connected'
        ]);
    });

    Route::post('sanctum/token', 'userTokenController');

    Route::apiresource('products', 'ProductController');
    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});


