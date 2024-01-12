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

use Acme\Reporting\HtmlOutput;
use Acme\Reporting\SalesReporter;
use Acme\Repositories\SalesRepository;

Auth::routes();

Route::group([
    'middleware' => 'auth'
], function () {

    Route::get('/test', function (){
        $report = new SalesReporter(new SalesRepository);

        $begin = \Carbon\Carbon::now()->subDays(10);
        $end = \Carbon\Carbon::now();

        return $report->between($begin, $end, new HtmlOutput);
    });

    //= main home page
    Route::get('/', 'HomeController@home')->name('home');

    //= employee
    Route::resource('employee', 'EmployeeController', ['except' => [
        'show', 'destroy', 'store'
    ]]);

    //= lock
    Route::resource('lock', 'LockController', ['except' => [
        'show', 'destroy', 'store'
    ]]);

    // = ajax
    Route::group([
        'prefix' => 'ajax'
    ], function () {
        //main - displaying all employees with keys
        Route::get('main', 'HomeController@main')->name('main');

        //key
        Route::get('/key/lock/{lock_id}', 'KeyController@index')->name('key.index');
        Route::post('/key/store', 'KeyController@store')->name('key.store');
        Route::delete('/key/delete/{key_id}', 'KeyController@destroy')->name('key.destroy');

        //employee
        Route::get('employees', 'EmployeeController@employees')->name('employees');
        Route::post('employee', 'EmployeeController@store')->name('employee.store');
        Route::get('employee/{employee}', 'EmployeeController@show')->name('employee.show');
        Route::delete('employee/{employee}', 'EmployeeController@destroy')->name('employee.destroy');

        //lock
        Route::get('locks', 'LockController@locks')->name('locks');
        Route::post('lock', 'LockController@store')->name('lock.store');
        Route::get('lock/{lock}', 'LockController@show')->name('lock.show');
        Route::delete('lock/{lock}', 'LockController@destroy')->name('lock.destroy');

        //= employee_key crud
        Route::post('employee-key/store/', 'EmployeeController@employee_key_store')->name('employee_key.store');
        Route::put('employee-key/update/{employee_id}', 'EmployeeController@employee_key_update')->name('employee_key.update');
        Route::delete('employee-key/delete/{employee_id}/{key_id}', 'EmployeeController@employee_key_destroy')->name('employee_key.destroy');
    });

});