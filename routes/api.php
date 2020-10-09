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
Route::ApiResource('products', 'ProductsController');
Route::ApiResource('materials', 'MaterialsController');

Route::group(['prefix' => 'products/'], function() {
    Route::get('material/{id}', 'ProductsController@getProductsMaterial');
    Route::get('details/{id}', 'ProductsController@getProductDetails');
});

Route::ApiResource('attributes', 'AttributesController');
Route::ApiResource('files', 'FilesController');
Route::ApiResource('product-images', 'ProductImagesController');
