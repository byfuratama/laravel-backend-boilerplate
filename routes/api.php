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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([
    'middleware' => 'auth:api',
], function ($router) {

    $basic_routes = function($name, $controller) {
        Route::apiResource($name, $controller);
        Route::apiResource($name, $controller)->only([
            'create', 'store', 'update', 'destroy'
        ])->middleware('role:admin');
    };

    $basic_routes('kategori', 'KategoriController');


});

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});
