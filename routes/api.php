<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Procedures\OilPriceProcedure;

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

Route::group(['middleware' => 'api'], function () {
    Route::post('/getoilpricetrend', 'OilPriceController@index');
    // Route::get('/testfilldatabase', 'OilPriceController@fillDatabaseFromUri');
    Route::rpc('/v1', [
        OilPriceProcedure::class
    ])->name('rpc.GetOilPriceTrend');

});

