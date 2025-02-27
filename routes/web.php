<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PostLikeController;
// AUTH--------------------------------------------------------------------------------
// Trang đăng nhập & xử lý đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/doctor', [AuthController::class, 'loginAsDoctor'])->name('login.doctor');
Route::post('/login', [AuthController::class, 'processLogin']);

// Trang đăng ký & xử lý đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister']);

// Đăng xuất
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



// Xử lý ảnh
Route::post('/upload-image', [ImageController::class, 'uploadImage'])->name('upload.image');


// Test
Route::post('/upload-image-test', [TestController::class, 'upload'])->name('upload-image-test');


// Route::get('/', function () {
//     return view('index');
// });

//Home
Route::get('/about', function () {
    return view('pages.about-us');
})->name('about');

Route::get('/doctors', function () {
    return view('pages.list-doctors');
})->name('doctors');
Route::get('/appointment', function () {
    return view('pages.booking-appointment');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'detail'])->name('post.detail');
//Search
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search-results', [SearchController::class, 'results'])->name('search.results');
//Filter
Route::get('/filter-posts', [HomeController::class, 'filterPosts'])->name('filter.posts');

// Doctor
Route::get('/doctors/{id}/detail', [DoctorController::class, 'showDetail'])->name('doctor.detail');
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.list');
Route::put('/doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
Route::get('/doctor/profile', [DoctorController::class, 'profile'])->name('doctor.profile');

Route::get('/doctor/{doctor_id}/products', [DoctorController::class, 'getAffilateProduct'])->name('doctor.products');
Route::middleware(['auth:doctor'])->group(function () {
    Route::get('/doctor/appointments', [DoctorController::class, 'getAppointments'])->name('doctor.appointments');
});
Route::put('/appointments/{id}/approve', [DoctorController::class, 'approveAppointment'])->name('doctor.appointments.approve');
Route::put('/appointments/{id}/reject', [DoctorController::class, 'rejectAppointment'])->name('doctor.appointments.reject');
Route::put('/appointments/{id}/complete', [DoctorController::class, 'completeAppointment'])->name('doctor.appointments.complete');
Route::put('/appointments/{id}/cancel', [DoctorController::class, 'cancelAppointment'])->name('doctor.appointments.cancel');



// Post detail---------------
Route::get('/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
// Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::post('/post/{slug}/comment', [CommentController::class, 'store'])->name('post-comment.store');
// Route::get('/post/{slug}', [PostController::class, 'showDoctorPost'])->name('post.detail');
Route::get('/search/posts', [PostController::class, 'search'])->name('posts.search');

// User
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::middleware(['auth:web'])->group(function () {
    Route::get('/user/appointments', [UserController::class, 'getAppointments'])->name('user.appointments');
});
Route::get('/user/appointments', [UserController::class, 'getAppointments'])->name('user.appointments');
Route::post('/user/book-appointment', [UserController::class, 'bookAppointment'])->name('user.book.appointment');
Route::patch('/user/appointments/{id}/cancel', [UserController::class, 'cancelAppointment'])->name('user.appointments.cancel');
Route::get('/user/search-doctors', [UserController::class, 'searchDoctors'])->name('api.search.doctors');
// Route::middleware(['auth'])->group(function () {
//     Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
// });
Route::put('/user/profile/{id}', [UserController::class, 'update'])->name('profile.update');

// Commnent
Route::post('/post/{slug}/comment', [CommentController::class, 'store'])->name('post-comment.store');

//Like
Route::post('/like-post', [PostLikeController::class, 'toggleLike'])->name('post.like');
