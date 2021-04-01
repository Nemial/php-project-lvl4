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

Route::resources(
    [
        'task_statuses' => TaskStatusController::class,
        'labels' => LabelController::class,
        'tasks' => TaskController::class
    ]
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
