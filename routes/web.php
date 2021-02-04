<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
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
        Route::resource('labels', LabelController::class)->only(
            ['create', 'store', 'edit', 'update', 'destroy']
        );
        Route::resource('tasks', TaskController::class)->only(
            ['create', 'store', 'edit', 'update']
        );
        Route::resource('tasks', TaskController::class)->only('destroy')
            ->middleware('can:delete,task');
    }
);

Route::resource('task_statuses', TaskStatusController::class)->except(
    ['create', 'store', 'edit', 'update', 'destroy']
);

Route::resource('labels', LabelController::class)->except(
    ['create', 'store', 'edit', 'update', 'destroy']
);

Route::resource('tasks', TaskController::class)->except(
    ['create', 'store', 'edit', 'update', 'destroy']
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
