<?php

use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\ForumThreadController;
use App\Http\Controllers\PolicyController;
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

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-results', [HomeController::class, 'searchResults'])->name('search.results');


Route::get('/categories', [CategoryController::class, 'allCategories'])->name('categories.all');

// Dopdown

Route::get('/dropdown/clinics', [DropdownMenuController::class, 'getClinicsDropdownData']);

// Clinic

// Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.list');
Route::get('/clinics/{type?}',  [ClinicController::class, 'index'])->name('clinics.list')->where('type', 'hospital|clinic');
Route::get('/clinic/{slug}/detail', [ClinicController::class, 'show'])->name('clinics.detail');


// Tool
Route::view('/pages/health-tools/bmi', 'pages.health-tools.tool-BMI')->name('tools.bmi');
Route::view('/tools/body-fat-calculator', 'pages.health-tools.tool-body-fat')->name('tools.body-fat');
Route::view('/tools/bmr-calculator', 'pages.health-tools.tool-bmr')->name('tools.bmr');
Route::view('/tools/blood-pressure', 'pages.health-tools.tool-blood-pressure')->name('tools.blood-pressure');
Route::view('/tools/heart-rate-zones', 'pages.health-tools.tool-heart-rate-zones')->name('tools.heart-rate-zones');
Route::view('/tools/heart-risk', 'pages.health-tools.tool-heart-risk')->name('tools.heart-risk');
Route::view('/tools/calorie-needs', 'pages.health-tools.tool-calorie-needs')->name('tools.calorie-needs');
Route::view('/tools/water-intake', 'pages.health-tools.tool-water-intake')->name('tools.water-intake');
Route::view('/tools/macro-calculator', 'pages.health-tools.tool-macro-calculator')->name('tools.macro-calculator');
Route::view('/tools/pregnancy-calculator', 'pages.health-tools.tool-pregnancy-calculator')->name('tools.pregnancy-calculator');
Route::view('/tools/diabetes-risk', 'pages.health-tools.tool-diabetes-risk')->name('tools.diabetes-risk');
Route::view('/tools/sleep-calculator', 'pages.health-tools.tool-sleep-calculator')->name('tools.sleep-calculator');
Route::view('/tools', 'pages.health-tools.all-tool')->name('tools.index');




Route::group(['prefix' => 'specialties'], function () {
    Route::get('/', [SpecialtyController::class, 'index'])->name('specialties.index');
    Route::get('/lich-su-kien-chuyen-mon', [SpecialtyController::class, 'events'])->name('specialties.events');
    Route::get('/cau-chuyen-nghe-y', [SpecialtyController::class, 'stories'])->name('specialties.stories');
    Route::get('/thanh-tuu-nghien-cuu', [SpecialtyController::class, 'research'])->name('specialties.research');
    Route::get('/video-chia-se-chuyen-mon', [SpecialtyController::class, 'videos'])->name('specialties.videos');

    // Routes cho danh mục con nếu cần thiết
    Route::get('/hoi-thao-dao-tao', [SpecialtyController::class, 'eventCategory'])->name('specialties.event.training');
    Route::get('/workshop-noi-bo', [SpecialtyController::class, 'eventCategory'])->name('specialties.event.workshop');
    // Các routes con khác...
});


// Routes cho phần phương pháp điều trị
Route::group(['prefix' => 'treatment'], function () {
    Route::get('/', [ServiceController::class, 'treatment_index'])->name('treatment.index');
    Route::get('/detail/{slug}', [ServiceController::class, 'detail'])->name('treatment.detail');
    Route::get('/{slug}', [ServiceController::class, 'category'])->name('treatment.category');
});





/// Tranng dịch vụ tại nhà

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');


// =====================         Forum    ===============================================


Route::prefix('forum')->name('forum.')->group(function () {
    // Routes công khai
    Route::get('/', [ForumController::class, 'index'])->name('index');
    // Route::get('/forum/category/{slug}/threads', [ForumController::class, 'categoryThreads'])->name('forum.category.threads');
    Route::get('/category/{slug}/threads', [ForumController::class, 'categoryThreads'])->name('category.threads');
    Route::get('/{category:slug}/{threadSlug}', [ForumThreadController::class, 'show'])->name('threads.show');


    // Search
    Route::get('/search', [ForumController::class, 'search'])->name('search');


    // Post
    Route::get('/post/category/{slug}', [ForumPostController::class, 'categoryPosts'])->name('posts.category');
    Route::get('/post/{categorySlug}/{postSlug}', [ForumPostController::class, 'showCategoryPost'])->name('posts.show');
    Route::post('/post/{categorySlug}/{postSlug}/views', [ForumPostController::class, 'incrementCategoryPostViews'])->name('posts.incrementViews');
    Route::get('/posts/featured', [ForumPostController::class, 'getFeaturedCategoryPosts'])->name('posts.featured');
    Route::get('/posts/search', [ForumPostController::class, 'searchCategoryPosts'])->name('posts.search');



    // Routes cần xác thực
    Route::get('/{category:slug}/threads/create', [ForumThreadController::class, 'create'])->name('threads.create');
    Route::post('/threads', [ForumThreadController::class, 'store'])->name('threads.store');
    Route::get('/{category:slug}/{threadSlug}/edit', [ForumThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/{category:slug}/{threadSlug}', [ForumThreadController::class, 'update'])->name('threads.update');
    Route::delete('/{category:slug}/{threadSlug}', [ForumThreadController::class, 'destroy'])->name('threads.destroy');

    // Cmt in thread routes
    Route::post('/{category:slug}/{threadSlug}/posts', [ForumPostController::class, 'store'])->name('posts.store');
    Route::get('/{category:slug}/{threadSlug}/posts/{post}/edit', [ForumPostController::class, 'edit'])->name('posts.edit');
    Route::put('/{category:slug}/{threadSlug}/posts/{post}', [ForumPostController::class, 'update'])->name('posts.update');
    Route::delete('/{category:slug}/{threadSlug}/posts/{post}', [ForumPostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/{category:slug}/{threadSlug}/posts/{post}/like', [ForumPostController::class, 'like'])->name('posts.like');
});




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'detail'])->name('post.detail');
// Delete post
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
//Search
Route::get('/search', [SearchController::class, 'search'])->name('search');
// Route::get('/search-results', [SearchController::class, 'results'])->name('search.results');
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
// Thêm vào web.php để debug
// Route::get('/posts/store', function () {
//     return 'Bạn đang truy cập bằng GET. Hãy sử dụng form để POST.';
// });
// Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::post('/post/{slug}/comment', [CommentController::class, 'store'])->name('post-comment.store');
// Route::get('/post/{slug}', [PostController::class, 'showDoctorPost'])->name('post.detail');
Route::get('/search/posts', [PostController::class, 'search'])->name('posts.search');
Route::get('/doctor/posts/{id}/edit-data', [PostController::class, 'getPostData'])->name('doctor.posts.edit-data');
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


// Policy
Route::get('/chinh-sach-bao-mat', [PolicyController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/dieu-khoan-su-dung', [PolicyController::class, 'termsOfService'])->name('terms.service');
