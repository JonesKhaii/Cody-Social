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
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DropdownMenuController;
use App\Http\Controllers\ClinicController;
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

// Dopdown

Route::get('/dropdown/clinics', [DropdownMenuController::class, 'getClinicsDropdownData']);

// Clinic

Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.list');
Route::get('/clinics/{type?}',  [ClinicController::class, 'index'])->name('clinics.list')->where('type', 'hospital|clinic');
Route::get('/clinic/{slug}/detail', [ClinicController::class, 'show'])->name('clinics.detail');


// Tool
Route::view('/pages/health-tools/bmi', 'pages.health-tools.tool-BMI')->name('tools.bmi');
Route::view('/tools/body-fat-calculator', 'pages.health-tools.tool-body-fat')->name('tools.body-fat');
Route::view('/tools/bmr-calculator', 'pages.health-tools.tool-bmr')->name('tools.bmr');




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'detail'])->name('post.detail');
// Delete post
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
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


Route::get('/doctor/post-interactions', [DoctorController::class, 'getPostInteractions'])->name('doctor.postInteractions');
Route::get('/doctor/appointments-stats', [DoctorController::class, 'getAppointmentStats'])->name('doctor.appointments.stats');
Route::get('/doctor/appointments-time', [DoctorController::class, 'getAppointmentsByTimeframe'])->name('doctor.appointmentsStats');
Route::get('/doctor/appointments/{id}/details', [AppointmentController::class, 'showDetails'])->name('doctor.appointments.details');

Route::get('/doctors/list', [DoctorController::class, 'listWithFilter'])->name('doctors.filter');
// Affialte 
Route::get('/affiliate/search-product', [AffiliateController::class, 'searchProduct']);
Route::get('/affiliate/search-product-table', [ProductController::class, 'searchProductTable']);
Route::post('/affiliate/generate-link/{product_slug}', [AffiliateController::class, 'generateLink']);



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
Route::get('/appointments/{id}/details', [UserController::class, 'getAppointmentDetails']);

Route::get('/user/appointments', [UserController::class, 'getAppointments'])->name('user.appointments');
Route::post('/user/book-appointment', [UserController::class, 'bookAppointment'])->name('user.book.appointment');
Route::patch('/user/appointments/{id}/cancel', [UserController::class, 'cancelAppointment'])->name('user.appointments.cancel');
Route::get('/user/search-doctors', [UserController::class, 'searchDoctors'])->name('api.search.doctors');
Route::put('/user/profile/{id}', [UserController::class, 'update'])->name('profile.update');


// Booking appointment
Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/specialty', [BookingController::class, 'specialty'])->name('specialty');
    Route::post('/service', [BookingController::class, 'service'])->name('service');
    Route::post('/datetime', [BookingController::class, 'datetime'])->name('datetime');
    Route::post('/information', [BookingController::class, 'information'])->name('information');
    Route::post('/payment', [BookingController::class, 'payment'])->name('payment');
    Route::post('/confirmation', [BookingController::class, 'confirmation'])->name('confirmation');
});
Route::post('/booking/start', [BookingController::class, 'start'])->name('booking.start');
Route::get('/booking/services-by-specialization/{id}', [BookingController::class, 'getServicesBySpecialization']);
Route::post('/booking/appointment-type', [BookingController::class, 'appointmentType'])->name('booking.appointmentType');

Route::post('/booking/datetime', [BookingController::class, 'datetime'])->name('booking.datetime');
Route::post('/booking/info', [BookingController::class, 'info'])->name('booking.info');
// Route::post('/booking/payment', [BookingController::class, 'payment'])->name('booking.payment');
Route::post('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
Route::get('booking/back/{step}', [BookingController::class, 'goBack'])->name('booking.back');

Route::get('/booking/appointment-type', [BookingController::class, 'appointmentTypeGet'])->name('booking.appointmentType.get');
Route::get('/booking/datetime', [BookingController::class, 'datetimeGet'])->name('booking.datetime.get');
Route::get('/booking/info', [BookingController::class, 'informationGet'])->name('booking.info.get');
// Route::get('/booking/payment', [BookingController::class, 'paymentGet'])->name('booking.payment.get');
Route::get('/booking/confirm', [BookingController::class, 'confirmationGet'])->name('booking.confirm.get');


// Commnent
Route::post('/post/{slug}/comment', [CommentController::class, 'store'])->name('post-comment.store');

//Like
Route::post('/like-post', [PostLikeController::class, 'toggleLike'])->name('post.like');

// Category
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
// API:
// Image
Route::post('/upload-image', [ImageController::class, 'uploadImage'])->name('upload.image');


// Notification routes

// Notification routes for user
// Route cho User
Route::middleware(['auth:web'])->prefix('user')->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'fetchUnread']);
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('user.notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('user.notifications.markAllRead');
});

// Route cho Doctor
Route::middleware(['auth:doctor'])->prefix('doctor')->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'fetchUnread']);
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('doctor.notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('doctor.notifications.markAllRead');
});


// Phần thống kê ở trang bác sĩ

// Route::middleware(['auth:doctor'])->prefix('doctor')->group(function () {
//     Route::get('/post-stats', [DoctorController::class, 'getPostStatsPerPost']);
//     Route::get('/post-totals', [DoctorController::class, 'getPostInteractionTotals']);
// });

Route::prefix('doctor')->middleware('auth:doctor')->group(function () {
    // =====================Post=============================
    Route::get('/post-kpi', [DoctorController::class, 'getPostKPI']);
    Route::get('/post-trend', [DoctorController::class, 'getPostTrend']);
    Route::get('/post-top', [DoctorController::class, 'getTopPosts']);
    Route::get('/post-category-distribution', [DoctorController::class, 'getCategoryDistribution']);
    Route::get('/post-detail-stats', [DoctorController::class, 'getPostStatsPerPost']);
    // =====================Appointment=============================
    Route::get('/appointment-kpi', [DoctorController::class, 'getAppointmentKPI']);
    Route::get('/appointment-trend', [DoctorController::class, 'getAppointmentTrend']);
    Route::get('/appointment-type-distribution', [DoctorController::class, 'getAppointmentTypeDistribution']);
    Route::get('/appointment-comparison', [DoctorController::class, 'getAppointmentComparison']);
});
