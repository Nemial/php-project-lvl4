<?php

use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get(
    '/',
    function () {
        return view('home');
    }
);

Auth::routes();


Route::middleware('auth')->group(
    function () {
        Route::resource('task_statuses', TaskStatusController::class)->only(
            ['create', 'store', 'edit', 'update', 'destroy']
        );
    }
);

Route::resource('task_statuses', TaskStatusController::class)->except(
    ['create', 'store', 'edit', 'update', 'destroy']
);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
