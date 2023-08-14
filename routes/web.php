<?php

use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ClassWorkController;
use App\Http\Controllers\CommentController;
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


Route::resource('classrooms',ClassroomsController::class);



Route::resource('classrooms.classworks',ClassWorkController::class);



Route::get('/classrooms/{classroom}/topics',[TopicsController::class,'classroomTopics'])->name('show.topics.classroom');


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');










Route::get('classrooms/{classroom}/people',[ClassroomPeopleController::class,'index'])->name('classroom.people');

Route::delete('classrooms/{classroom}/people',[ClassroomPeopleController::class,'destroy'])->name('classroom.people.destroy');





Route::post('comment',[CommentController::class,'store'])->name('comment.store');



});

Route::get('classroom/{classroom}/join',[JoinClassroomController::class,'create'])
->middleware('signed')
->name('classroom.join');
Route::post('classroom/{classroom}/join',[JoinClassroomController::class,'store'])->name('classroom..join.store');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





require __DIR__.'/auth.php';




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
