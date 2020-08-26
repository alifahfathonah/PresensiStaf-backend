<?php

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

Route::get('/maps', 'HomeController@index')->name('maps');
Route::post('/entity/{id}', 'HomeController@updateEntity')->name('update.entity');

Route::get('/employee/get', 'UserController@getEmployee')->name('employee.get');
Route::get('/employee/create', 'UserController@createEmployee')->name('employee.create');
Route::post('/employee/post', 'UserController@postEmployee')->name('employee.post');
Route::get('/employee/{id}/edit', 'UserController@getDetailEmployee')->name('employee.edit');
Route::put('/employee/{id}/put', 'UserController@updateEmployee')->name('employee.put');
Route::delete('/employee/{id}/delete', 'UserController@userDashboard')->name('employee.delete');
Route::get('api/employee', 'UserController@apiEmployee')->name('api.employee'); // untuk datatable yajra

Route::resource('sick', 'SickController');
Route::get('api/sick', 'SickController@apiSick')->name('api.sick'); // untuk datatable yajra
Route::resource('leave', 'LeaveController');
Route::get('api/leave', 'LeaveController@apiLeave')->name('api.leave'); // untuk datatable yajra
Route::resource('leave_staf', 'LeaveStafController');
Route::get('api/leave_staf', 'LeaveStafController@apiLeaveStaf')->name('api.leave_staf'); // untuk datatable yajra
Route::resource('periode', 'PeriodeController');
Route::get('api/periode', 'PeriodeController@apiPeriode')->name('api.periode'); // untuk datatable yajra


Route::post('/api/getPeriodeByUsers', 'LeaveController@getPeriodeByUsers');
