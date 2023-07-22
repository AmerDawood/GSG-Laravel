<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\TopicsController;

/*
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';






Route::resource('topics',TopicsController::class)->middleware('auth');


Route::get('/classrooms',[ClassroomsController::class,'index'])->name('classroom.index');
Route::get('/classrooms/create',[ClassroomsController::class,'create']);

Route::post('/classroom/store',[ClassroomsController::class,'store'])->name('classromm.store');


Route::get('classrooms/{id}/edit',[ClassroomsController::class,'edit'])->name('edit.classroom');
Route::put('classrooms/{id}/update',[ClassroomsController::class,'update'])->name('update.classroom');



Route::get('/classrooms/{id}',[ClassroomsController::class,'show'])->name('show.classroom');

Route::delete('classrooms/{id}/delete',[ClassroomsController::class,'destroy'])->name('destroy.classroom');



