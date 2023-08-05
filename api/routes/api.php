<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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

Route::group(['middleware' => ['force.json']],function(){

    Route::get('hello', function () {
        return auth()->user();
    });
    
    Route::get('/', function () {
        return "Blogify API";
    });

    Route::get('/error', function () {
        return response()->json([
            'message' => 'You are not authorized to access this resource',
            'error'=>true
        ], 404);
    });
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => 'blogs'], function () {
            $blog = BlogController::class;
            Route::get('', [$blog, 'index']);
            Route::get('{id}', [$blog, 'show']);
            Route::post('', [$blog, 'store']);
            Route::put('', [$blog, 'edit']);
            Route::delete('{id}', [$blog, 'destroy']);
        });
    
        Route::group(['prefix' => 'users'], function () {
            $user = UserController::class;
            Route::get('', [$user, 'index']);
            Route::get('{id}', [$user, 'show']);
            Route::post('', [$user, 'store']);
            Route::put('', [$user, 'edit']);
            Route::delete('{id}', [$user, 'destroy']);
        });
    });
    
    Route::group(['prefix' => 'auth'], function () {
        $auth = AuthController::class;
        Route::post('register', [$auth, 'register']);
        Route::post('login', [$auth, 'login']);
    
        Route::group(['middleware' => ['auth:sanctum']], function () {
            $auth = AuthController::class;
            Route::post('logout', [$auth, 'logout']);
            Route::get('me', [$auth, 'me']);
        });
    });

});