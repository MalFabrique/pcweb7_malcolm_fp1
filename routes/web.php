<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/myfamily', [App\Http\Controllers\MyFamilyController::class, 'index'])->name('myfamily');

Route::get('/profile/create', [App\Http\Controllers\ProfileController::class, 'create']);
Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'postCreate'])->name('profile.postCreate');
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit']);
Route::post('/profile/{id}/update', [App\Http\Controllers\ProfileController::class, 'postEdit'])->name('profile.postEdit');

// meetings
Route::get('/meetings', [App\Http\Controllers\CalendarController::class, 'get_meetings'])->name('get_meetings');
Route::post('/meetings', [App\Http\Controllers\CalendarController::class, 'create_meeting'])->name('create_meeting');
Route::post('/meetings/delete', [App\Http\Controllers\CalendarController::class, 'delete_meeting'])->name('delete_meeting');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::get('/profile/{id}', [App\Http\Controllers\ProfileController::class, 'user_profile'])->name('user_profile');
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');



Route::resource('post', App\Http\Controllers\PostController::class);

