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

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/entity/{id}', 'HomeController@updateEntity')->name('update.entity');

Route::get('/employee/get', 'UserController@getEmployee')->name('employee.get');
Route::get('/employee/create', 'UserController@createEmployee')->name('employee.create');
Route::post('/employee/post', 'UserController@postEmployee')->name('employee.post');
Route::get('/employee/{id}/edit', 'UserController@getDetailEmployee')->name('employee.edit');
// Route::put('/employee/{id}/put', 'UserController@updateEmployee')->name('employee.put');
Route::delete('/employee/{id}/delete', 'UserController@userDashboard')->name('employee.delete');
Route::get('api/employee', 'UserController@apiEmployee')->name('api.employee'); // untuk datatable yajra
