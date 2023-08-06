<?php

use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ClassWorkController;
use App\Http\Controllers\JoinClassroomController;
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
Route::middleware(['auth'])->group(function(){

    Route::get('/topics/trashed',[TopicsController::class,'trashed'])->name('topic.trashed');

    Route::put('/topics/trashed/{topic}',[TopicsController::class,'restore'])->name('topic.restore');

    Route::delete('/topics/trashed/{topic}',[TopicsController::class,'forceDelete'])->name('topic.force-delete');


    Route::resource('topics',TopicsController::class)->middleware('auth');



Route::get('/classroom/trashed',[ClassroomsController::class,'trashed'])->name('classroom.trashed');

Route::put('/classroom/trashed/{classroom}',[ClassroomsController::class,'restore'])->name('classroom.restore');

Route::delete('/classroom/trashed/{classroom}',[ClassroomsController::class,'forceDelete'])->name('classroom.force-delete');





// Route::get('/classrooms',[ClassroomsController::class,'index'])->name('classroom.index');
// Route::get('/classrooms/create',[ClassroomsController::class,'create']);
// Route::post('/classroom/store',[ClassroomsController::class,'store'])->name('classromm.store');
// Route::get('classrooms/{id}/edit',[ClassroomsController::class,'edit'])->name('edit.classroom');
// Route::put('classrooms/{id}/update',[ClassroomsController::class,'update'])->name('update.classroom');
// Route::get('/classrooms/show/{id}',[ClassroomsController::class,'show'])->name('show.classroom');
// Route::delete('classrooms/{id}/delete',[ClassroomsController::class,'destroy'])->name('destroy.classroom');


Route::resource('classrooms',ClassroomsController::class);



// Route::resource('classrooms.classworks',ClassWorkController::class)->shallow();
Route::resource('classrooms.classworks',ClassWorkController::class);



Route::get('/classrooms/{classroom}/topics',[TopicsController::class,'classroomTopics'])->name('show.topics.classroom');


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



Route::get('classroom/{classroom}/join',[JoinClassroomController::class,'create'])
->middleware('signed')
->name('classroom.join');
Route::post('classroom/{classroom}/join',[JoinClassroomController::class,'store'])->name('classroom..join.store');


Route::get('classrooms/{classroom}/people',[ClassroomPeopleController::class,'index'])->name('classroom.people');

Route::delete('classrooms/{classroom}/people',[ClassroomPeopleController::class,'destroy'])->name('classroom.people.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





require __DIR__.'/auth.php';




