<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SystemAuth;
use App\Http\Middleware\CheckSystemAuth;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\LoginAuth;
use App\Http\Middleware\ClientAuth;
use App\Http\Middleware\LoginClientAuth;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProgressController;
use App\Http\Controllers\Client\ClientController;

Route::group(['middleware' => [SystemAuth::class]], function () {
    Route::group(['middleware' => [AdminAuth::class]], function () {
        Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
        Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/course', [CourseController::class, 'index'])->name('list_course');
        Route::get('/course/add', [CourseController::class, 'add'])->name('add_course');
        Route::post('/course/save', [CourseController::class, 'save'])->name('save_course');
        Route::post('/course/delete', [CourseController::class, 'delete'])->name('delete_course');
        Route::get('/course/edit/{id}', [CourseController::class, 'edit'])->name('edit_course');
        Route::post('/course/change_stt', [CourseController::class, 'change_stt'])->name('change_stt_course');
        Route::get('/unit', [UnitController::class, 'index'])->name('list_unit');
        Route::get('/unit/add', [UnitController::class, 'add'])->name('add_unit');
        Route::post('/unit/save', [UnitController::class, 'save'])->name('save_unit');
        Route::post('/unit/delete', [UnitController::class, 'delete'])->name('delete_unit');
        Route::get('/unit/edit/{id}', [UnitController::class, 'edit'])->name('edit_unit');
        Route::post('/unit/change_stt', [UnitController::class, 'change_stt'])->name('change_stt_unit');
        Route::get('/user', [UserController::class, 'index'])->name('list_user');
        Route::get('/user/add', [UserController::class, 'add'])->name('add_user');
        Route::post('/user/save', [UserController::class, 'save'])->name('save_user');
        Route::post('/user/delete', [UserController::class, 'delete'])->name('delete_user');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('edit_user');
        Route::post('/user/change_stt', [UserController::class, 'change_stt'])->name('change_stt_user');
        Route::post('/user/update_password', [UserController::class, 'update_password'])->name('update_password');
        Route::get('/progress', [ProgressController::class, 'index'])->name('list_progress');
        Route::get('/progress/update/{id}', [ProgressController::class, 'update'])->name('update_progress');
        Route::post('/progress/save', [ProgressController::class, 'save'])->name('save_progress');
        Route::post('/progress/complete', [ProgressController::class, 'complete'])->name('complete_progress');
    });
    Route::group(['middleware' => [LoginAuth::class]], function () {
        Route::get('/admin/login', function () {return view('admin.login');})->name('login');
        Route::post('/admin/login', [AdminController::class, 'login'])->name('login');
    });

    Route::group(['middleware' => [ClientAuth::class]], function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/logout', [ClientController::class, 'logout'])->name('logout_client');
    });

    Route::group(['middleware' => [LoginClientAuth::class]], function () {
        Route::get('/login', function () {return view('client.login');})->name('login_client');
        Route::post('/login', [ClientController::class, 'login'])->name('login_client');
    });
});

Route::group(['middleware' => [CheckSystemAuth::class]], function () {
    Route::get('/system', [SystemController::class, 'index'])->name('system');
    Route::post('/system', [SystemController::class, 'save'])->name('save_system');
});
