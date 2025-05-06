<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SystemAuth;
use App\Http\Middleware\CheckSystemAuth;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\LoginAuth;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\unitController;

Route::group(['middleware' => [SystemAuth::class]], function () {
    Route::group(['middleware' => [AdminAuth::class]], function () {
        Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
        Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/course', [CourseController::class, 'index'])->name('list_course');
        Route::get('/course/add', [CourseController::class, 'add'])->name('add_course');
        Route::post('/course/save', [CourseController::class, 'save'])->name('save_course');
        Route::post('/course/delete', [CourseController::class, 'delete'])->name('delete_course');
        Route::get('/course/edit/{id}', [CourseController::class, 'edit'])->name('edit_course');
        Route::post('/course/change_stt', [CourseController::class, 'change_stt'])->name('change_stt');
        Route::get('/unit', [unitController::class, 'index'])->name('list_unit');
        Route::get('/unit/add', [unitController::class, 'add'])->name('add_unit');
        Route::post('/unit/save', [unitController::class, 'save'])->name('save_unit');
        Route::post('/unit/delete', [unitController::class, 'delete'])->name('delete_unit');
        Route::get('/unit/edit/{id}', [unitController::class, 'edit'])->name('edit_unit');
        Route::post('/unit/change_stt', [unitController::class, 'change_stt'])->name('change_stt');
        
    });
    Route::group(['middleware' => [LoginAuth::class]], function () {
        Route::get('/admin/login', function () {return view('admin.login');})->name('login');
        Route::post('/admin/login', [AdminController::class, 'login'])->name('login');
    });

    Route::get('/', function () {
        return view('welcome');
    });
});

Route::group(['middleware' => [CheckSystemAuth::class]], function () {
    Route::get('/system', [SystemController::class, 'index'])->name('system');
    Route::post('/system', [SystemController::class, 'save'])->name('save_system');
});
