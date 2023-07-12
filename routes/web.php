<?php

use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\TopicsController;
use Illuminate\Support\Facades\Route;

/*
|
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::resource('topics',TopicsController::class);


Route::get('/classrooms',[ClassroomsController::class,'index'])->name('classroom.index');
Route::get('/classrooms/create',[ClassroomsController::class,'create']);

Route::post('/classroom/store',[ClassroomsController::class,'store'])->name('classromm.store');


Route::get('classrooms/{id}/edit',[ClassroomsController::class,'edit'])->name('edit.classroom');
Route::put('classrooms/{id}/update',[ClassroomsController::class,'update'])->name('update.classroom');



Route::get('/classrooms/{id}',[ClassroomsController::class,'show'])->name('show.classroom');

Route::delete('classrooms/{id}/delete',[ClassroomsController::class,'destroy'])->name('destroy.classroom');
