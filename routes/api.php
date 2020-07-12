<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\SendLocation;

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


// Gửi dữ liệu đồng thời tạo sự kiện gửi Location
Route::post('/map', function (Request $request) {
    $lat = floatval($request->lat);
    $lng = floatval($request->lng);
    $pickup = floatval($request->pickup);
    $code = $request->code;
    $location = ['location' => ['lat' => $lat, 'lng' => $lng], 'pickup' => $pickup, 'code' => $code];
    event(new SendLocation($location));
    return response()->json(['status' => 'success', 'data' => $location]);
});

// send mail

Route::post('/sendMail', 'ProductController@sendMail');


Route::get('/product', 'ProductController@getProduct');

Route::post('/settingOriginGPS', 'LocationController@updateOriginLocation');

