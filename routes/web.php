<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('home');

});


Route::post('/store', [EmployeeController::class, 'store'])->name('store');
Route::get('/getall', [EmployeeController::class, 'getall'])->name('getall');
Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('edit');
Route::post('/employee/update', [EmployeeController::class, 'update'])->name('update');
Route::delete('/employee/delete', [EmployeeController::class, 'delete'])->name('delete');
