<?php

use Illuminate\Http\Request;

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

Route::post('login', 'UserController@login');

Route::middleware('jwt.auth')->group(function () {

    Route::post('attendance', 'AttendanceController@setAttendance');
    Route::post('attendanceWithFace', 'AttendanceController@setAttendanceWithFace');
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('getStateForToday', 'AttendanceController@getStateForToday');

    Route::get('getSchedule', 'AttendanceController@getSchedule');

});

