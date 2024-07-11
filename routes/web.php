<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('student',[studentController::class,'all']);
Route::post('students',[studentController::class,'store'])->name('students');
