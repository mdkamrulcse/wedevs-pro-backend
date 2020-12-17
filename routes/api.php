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

Route::get('/', function () {
    return 'Welcome to the api service.';
});
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

Route::middleware('auth:api')->group(function () {
    Route::delete('products/batchDelete', 'ProductController@batchDelete');
    Route::get('products/by/subCategory', 'ProductController@getProductsBySubCategory');
    Route::get('products/by/category', 'ProductController@getProductsByCategory');
    Route::get('products/getAllProducts', 'ProductController@getAllProducts');
    Route::get('products/getProductsBySearchTerm', 'ProductController@getProductsBySearchTerm');
    Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');
});
