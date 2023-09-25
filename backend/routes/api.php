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
Route::fallback(function (Request $request) {
    return response()->json(['status' => false, 'code' => 404, 'message' => 'Unauthenticated or ' . $request->method() . ' method not allowed '], 404);
});

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::group(['prefix'=>'posts'],function(){
    Route::get('/', [App\Http\Controllers\API\PostController::class, 'index']);
    Route::get('/{slug}', [App\Http\Controllers\API\PostController::class, 'view']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
    Route::get('/profile', [App\Http\Controllers\API\AuthController::class, 'profile']);

    /*Route::group(['prefix'=>'prayer'],function(){
        Route::get('/', [App\Http\Controllers\API\PrayerController::class, 'index']);
    });*/

});


/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
