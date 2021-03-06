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

use Symfony\Component\HttpFoundation\Response;

Route::get('/', function () {
    return view('welcome');
});

Route::get('download/{filename}', function($filename)
{
    // Check if file exists in app/storage/file folder
    $file_path = asset('../public/file/'.$filename);
    $download_link = link_to_asset('file/'.$filename);
    return $download_link;
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');

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

Route::resource('presensi', 'PresensiController');
Route::get('presensi/recap/db', 'PresensiController@recap')->name('presensi.recap');
Route::get('api/presensi', 'PresensiController@apiPresensi')->name('api.presensi'); // untuk datatable yajra
Route::get('api/presensi/recap/db', 'PresensiController@apiPresensiRecap')->name('api.presensi.recap'); // untuk datatable yajra
Route::resource('sick', 'SickController');
Route::get('api/sick', 'SickController@apiSick')->name('api.sick'); // untuk datatable yajra
Route::resource('permit', 'PermitController');
Route::get('api/permit', 'PermitController@apiPermit')->name('api.permit'); // untuk datatable yajra
Route::resource('leave', 'LeaveController');
Route::get('api/leave', 'LeaveController@apiLeave')->name('api.leave'); // untuk datatable yajra
Route::resource('leave_staf', 'LeaveStafController');
Route::get('api/leave_staf', 'LeaveStafController@apiLeaveStaf')->name('api.leave_staf'); // untuk datatable yajra
// Route::resource('schedule', 'ScheduleController');
Route::get('/employee/{id}/schedule', 'ScheduleController@index')->name('schedule.index');
Route::get('/employee/{id}/schedule/create', 'ScheduleController@create')->name('schedule.create');
Route::post('/employee/{userid}/schedule/store', 'ScheduleController@store')->name('schedule.store');
Route::get('/employee/{userid}/schedule/{id}/edit', 'ScheduleController@edit')->name('schedule.edit');
Route::put('/employee/{userid}/schedule/{id}/edit', 'ScheduleController@update')->name('schedule.update');
Route::delete('/employee/{userid}/schedule/{id}/destroy', 'ScheduleController@destroy')->name('schedule.destroy');
Route::get('api/schedule/{id}', 'ScheduleController@apiSchedule')->name('api.schedule'); // untuk datatable yajra
Route::resource('periode', 'PeriodeController');
Route::get('api/periode', 'PeriodeController@apiPeriode')->name('api.periode'); // untuk datatable yajra


Route::get('/api/getPeriodeByUsers', 'LeaveController@getPeriodeByUsers');
