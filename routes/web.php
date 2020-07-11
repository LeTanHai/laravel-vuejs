<?php

use Illuminate\Support\Facades\Route;
//use App\Events\SendLocation;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/location', 'LocationController@getLocation');

Route::post('/locationProduct', 'ProductController@updateLocationProduct');
Route::get('/product', 'ProductController@getProduct');
Route::post('/product', 'ProductController@updateStatus');

Route::get('/infoItems', 'ProductController@getInfoItem');

Route::get('/login_page', 'PagesController@loginPage')->name('login_page');
Route::post('/login_post', 'PagesController@loginPost')->name('login_post');
Route::get('admin', 'PagesController@adminIndex')->name('admin_index');
Route::get('user', 'PagesController@userIndex')->name('user_index');

//users
Route::get('/combo_box', 'UserController@search');

Route::post('/newProduct', 'ProductController@modifyProduct');

Route::get('/sendMail', 'ProductController@sendMail');

// // Gửi dữ liệu đồng thời tạo sự kiện gửi Location
// Route::post('/map', function (Request $request) {
//     $lat = $request->input('lat');
//     $long = $request->input('long');
//     $location = ['lat' => $lat, 'long' => $long];
//     event(new SendLocation($location));
//     return response()->json(['status' => 'success', 'data' => $location]);
// });