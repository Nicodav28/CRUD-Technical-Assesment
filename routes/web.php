<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ EmployeeController::class, 'view' ])->name('employees.view');
Route::get('/employees', [ EmployeeController::class, 'index' ])->name('employees.index');
Route::post('/employees', action: [ EmployeeController::class, 'store' ])->name('employees.store');
Route::get('/employees/{id}', [ EmployeeController::class, 'show' ])->name('employees.show');
Route::put('/employees/{id}', [ EmployeeController::class, 'update' ])->name('employees.update');
Route::delete('/employees/{id}', [ EmployeeController::class, 'destroy' ])->name('employees.destroy');

Route::get('/roles', [ RoleController::class, 'index' ])->name(name: 'roles.index');
Route::get('/deparments', [ AreaController::class, 'index' ])->name(name: 'area.index');
