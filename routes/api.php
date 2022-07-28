<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api',
              'namespace' => 'App\Http\Controllers',
              'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::post('payload', 'AuthController@payload');
    
});

Route::group(['middleware' => 'api','namespace' => 'App\Http\Controllers','prefix' => 'calendar'],function(){
    //Route::resource('calendar', CalendarController::class);
    Route::get('/', 'CalendarController@index')->name('calendar.index');  
    Route::post('/', 'CalendarController@store')->name('calendar.store');
    Route::delete('/{id}', 'CalendarController@destroy')->name('calendar.delete');      
});    


//Route::resource('calendar', CalendarController::class);
