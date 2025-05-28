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
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\RegisterCourseController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ClientAuthController;
use App\Http\Controllers\Client\ClientContactController;
use App\Http\Controllers\Client\ClientAboutController;
use App\Http\Controllers\Client\ClientCourseController;
use App\Http\Controllers\Client\ClientBlogController;
use App\Http\Controllers\Client\ClientGalleryController;
use App\Http\Controllers\Client\ClientUserController;
use App\Http\Controllers\Client\ClientStudyController;
use App\Http\Controllers\Client\ClientExerciseController;

Route::group(['middleware' => [SystemAuth::class]], function () {
    Route::group(['middleware' => [AdminAuth::class]], function () {
        Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
        Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');
        // Khóa học
        Route::get('/course', [CourseController::class, 'index'])->name('list_course');
        Route::get('/course/add', [CourseController::class, 'add'])->name('add_course');
        Route::post('/course/save', [CourseController::class, 'save'])->name('save_course');
        Route::post('/course/delete', [CourseController::class, 'delete'])->name('delete_course');
        Route::get('/course/edit/{id}', [CourseController::class, 'edit'])->name('edit_course');
        Route::post('/course/change_stt', [CourseController::class, 'changeStt'])->name('change_stt_course');
        Route::get('/course/search', [CourseController::class, 'search'])->name('search_course');
        // Bài học
        Route::get('/unit', [UnitController::class, 'index'])->name('list_unit');
        Route::get('/unit/add', [UnitController::class, 'add'])->name('add_unit');
        Route::post('/unit/save', [UnitController::class, 'save'])->name('save_unit');
        Route::post('/unit/delete', [UnitController::class, 'delete'])->name('delete_unit');
        Route::get('/unit/edit/{id}', [UnitController::class, 'edit'])->name('edit_unit');
        Route::post('/unit/change_stt', [UnitController::class, 'changeStt'])->name('change_stt_unit');
        Route::get('/unit/search', [UnitController::class, 'search'])->name('search_unit');
        // Học viên
        Route::get('/user', [UserController::class, 'index'])->name('list_user');
        Route::get('/user/add', [UserController::class, 'add'])->name('add_user');
        Route::post('/user/save', [UserController::class, 'save'])->name('save_user');
        Route::post('/user/delete', [UserController::class, 'delete'])->name('delete_user');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('edit_user');
        Route::post('/user/change_stt', [UserController::class, 'changeStt'])->name('change_stt_user');
        Route::post('/user/update_password', [UserController::class, 'updatePassword'])->name('update_password');
        Route::get('/user/search', [UserController::class, 'search'])->name('search_user');
        // Tiến độ học tập
        Route::get('/progress', [ProgressController::class, 'index'])->name('list_progress');
        Route::get('/progress/update/{id}', [ProgressController::class, 'update'])->name('update_progress');
        Route::post('/progress/save', [ProgressController::class, 'save'])->name('save_progress');
        Route::post('/progress/complete', [ProgressController::class, 'complete'])->name('complete_progress');
        // Slider
        Route::get('/slider', [SliderController::class, 'index'])->name('list_slider');
        Route::get('/slider/add', [SliderController::class, 'add'])->name('add_slider');
        Route::post('/slider/save', [SliderController::class, 'save'])->name('save_slider');
        Route::post('/slider/delete', [SliderController::class, 'delete'])->name('delete_slider');
        Route::get('/slider/edit/{id}', [SliderController::class, 'edit'])->name('edit_slider');
        Route::get('/slider/search', [SliderController::class, 'search'])->name('search_slider');
        // Blog
        Route::get('/blog', [BlogController::class, 'index'])->name('list_blog');
        Route::get('/blog/add', [BlogController::class, 'add'])->name('add_blog');
        Route::post('/blog/save', [BlogController::class, 'save'])->name('save_blog');
        Route::post('/blog/delete', [BlogController::class, 'delete'])->name('delete_blog');
        Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('edit_blog');
        Route::post('/blog/change_stt', [BlogController::class, 'changeStt'])->name('change_stt_blog');
        Route::get('/blog/search', [BlogController::class, 'search'])->name('search_blog');
        // Giới thiệu
        Route::get('/about', [AboutController::class, 'show'])->name('about');
        Route::post('/about/save', [AboutController::class, 'save'])->name('save_about');
        // Feedback
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('list_feedback');
        Route::get('/feedback/add', [FeedbackController::class, 'add'])->name('add_feedback');
        Route::post('/feedback/save', [FeedbackController::class, 'save'])->name('save_feedback');
        Route::post('/feedback/delete', [FeedbackController::class, 'delete'])->name('delete_feedback');
        Route::get('/feedback/edit/{id}', [FeedbackController::class, 'edit'])->name('edit_feedback');
        Route::get('/feedback/search', [FeedbackController::class, 'search'])->name('search_feedback');
        // Thư viện ảnh
        Route::get('/gallery', [GalleryController::class, 'index'])->name('list_gallery');
        Route::get('/gallery/add', [GalleryController::class, 'add'])->name('add_gallery');
        Route::post('/gallery/save', [GalleryController::class, 'save'])->name('save_gallery');
        Route::post('/gallery/delete', [GalleryController::class, 'delete'])->name('delete_gallery');
        Route::get('/gallery/edit/{id}', [GalleryController::class, 'edit'])->name('edit_gallery');
        Route::get('/gallery/search', [GalleryController::class, 'search'])->name('search_gallery');
        // Công ty
        Route::get('/company', [CompanyController::class, 'show'])->name('company');
        Route::post('/company/save', [CompanyController::class, 'save'])->name('save_company');
        // Liên hệ
        Route::get('/contact', [ContactController::class, 'index'])->name('list_contact');
        Route::post('/contact/delete', [ContactController::class, 'delete'])->name('delete_contact');
        Route::get('/contact/view/{id}', [ContactController::class, 'view'])->name('view_contact');
        Route::get('/contact/search', [ContactController::class, 'search'])->name('search_contact');
        // Liên hệ
        Route::get('/register-course', [RegisterCourseController::class, 'index'])->name('list_register_course');
        Route::post('/register-course/delete', [RegisterCourseController::class, 'delete'])->name('delete_register_course');
        Route::get('/register-course/view/{id}', [RegisterCourseController::class, 'view'])->name('view_register_course');
        Route::get('/register-course/search', [RegisterCourseController::class, 'search'])->name('search_register_course');
    });
    Route::group(['middleware' => [LoginAuth::class]], function () {
        Route::get('/admin/login', function () {return view('admin.login');})->name('login');
        Route::post('/admin/login', [AdminController::class, 'login'])->name('login');
    });

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/', [ClientContactController::class, 'contact'])->name('contact');
    Route::get('/gioi-thieu', [ClientAboutController::class, 'show'])->name('client_about');
    Route::get('/khoa-hoc', [ClientCourseController::class, 'show'])->name('course');
    Route::post('/khoa-hoc', [ClientCourseController::class, 'registerCourse'])->name('register_course');
    Route::get('/khoa-hoc/{slug}', [ClientCourseController::class, 'detail'])->name('course_detail');
    Route::get('/chia-se-kien-thuc', [ClientBlogController::class, 'show'])->name('blog');
    Route::get('/chia-se-kien-thuc/{slug}', [ClientBlogController::class, 'detail'])->name('blog_detail');
    Route::get('/thu-vien-anh', [ClientGalleryController::class, 'show'])->name('gallery');
    
    Route::group(['middleware' => [ClientAuth::class]], function () {
        Route::get('/logout', [ClientAuthController::class, 'logout'])->name('logout_client');
        Route::get('/thong-tin-tai-khoan', [ClientUserController::class, 'show'])->name('info_user');
        Route::post('/thong-tin-tai-khoan', [ClientUserController::class, 'update'])->name('update_user');
        Route::get('/thay-doi-mat-khau', [ClientUserController::class, 'showPassword'])->name('change_password');
        Route::post('/thay-doi-mat-khau', [ClientUserController::class, 'change_password'])->name('change_password');
        Route::get('/khoa-hoc-dang-hoc', [ClientStudyController::class, 'show'])->name('study');
        Route::post('/get-unit', [ClientStudyController::class, 'getUnits'])->name('get_unit');
        Route::post('/get-lesson', [ClientStudyController::class, 'getLessons'])->name('get_lesson');
        Route::post('/lesson', [ClientStudyController::class, 'lesson'])->name('lesson');
        Route::get('/lich-su-nop-bai-tap', [ClientExerciseController::class, 'show'])->name('history_exercise');
        Route::post('/lich-su-nop-bai-tap', [ClientExerciseController::class, 'update'])->name('update_exercise');
        Route::post('/xoa-lich-su-nop-bai-tap', [ClientExerciseController::class, 'delete'])->name('delete_exercise');
    });

    Route::group(['middleware' => [LoginClientAuth::class]], function () {
        Route::get('/login', function () {return view('client.login');})->name('login_client');
        Route::post('/login', [ClientAuthController::class, 'login'])->name('login_client');
    });
});

Route::group(['middleware' => [CheckSystemAuth::class]], function () {
    Route::get('/system', [SystemController::class, 'index'])->name('system');
    Route::post('/system', [SystemController::class, 'save'])->name('save_system');
});
