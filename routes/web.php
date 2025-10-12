<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Middleware\EnsureUserIsAdmin;

use App\Http\Controllers\Admin\CourseController   as AdminCourseController;
use App\Http\Controllers\Admin\ServiceController  as AdminServiceController;
use App\Http\Controllers\Admin\TopicesController  as AdminTopicesController;
use App\Http\Controllers\Admin\VacanciesController as AdminVacanciesController;

use App\Http\Controllers\CourseController         as FrontendCourseController;
use App\Http\Controllers\ServiceController        as FrontendServiceController;
use App\Http\Controllers\TopicesController        as FrontendTopicesController;
use App\Http\Controllers\VacanciesController      as FrontendVacanciesController;
use App\Http\Controllers\Admin\ResourcesController as AdminResourcesController;
use App\Http\Controllers\Admin\ResourceTypesController as AdminResourceTypesController;
use App\Http\Controllers\ResourcesController as FrontResourcesController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\TeamController as FrontTeam;
use App\Http\Controllers\FaqController as FrontendFaqController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AccreditationController;


/**
 * ADMIN
 */
Route::middleware(['auth', EnsureUserIsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('courses',   AdminCourseController::class);
        Route::resource('services',  AdminServiceController::class);
        Route::resource('topices',   AdminTopicesController::class);
        Route::resource('vacancies', AdminVacanciesController::class);
        Route::resource('resources', AdminResourcesController::class);
        Route::resource('resource-types', AdminResourceTypesController::class)->only(['index', 'store', 'destroy', 'show']);
        Route::resource('accreditations', AccreditationController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('teams', TeamController::class);
        Route::get('settings',        [SettingController::class, 'index'])->name('settings.index');
        Route::get('settings/edit',   [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::post('uploads/trix', [UploadController::class, 'trix'])->name('uploads.trix');
    });

/**
 * AUTH
 */
Route::get('/auth/{tab?}', [AuthController::class, 'show'])
    ->whereIn('tab', ['login', 'register'])
    ->name('auth.show');
Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'webLogout'])->name('logout');


/** Köhnə yönləndirmələr */
Route::get('/signup', fn() => redirect()->route('auth.show', 'register'));
Route::get('/signin', fn() => redirect()->route('auth.show', 'login'));

/** Ana səhifə */
Route::get('/', [HomeController::class, 'index'])->name('home');

/** Tasks */
Route::resource('tasks', TaskController::class);

/** Statik səhifələr */
Route::view('/blog-details', 'educve.blog-details')->name('blog-details');
// Contact page (GET) – səhifəni açır
Route::view('/contact', 'educve.contact')->name('contact');

// Contact submit (POST) – formu göndərir
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1') // istəsən saxla, istəsən sil
    ->name('contact.send');

/**
 * COURSES – FRONTEND
 */
Route::get('/courses',          [FrontendCourseController::class, 'index'])->name('courses-grid-view');
Route::get('/courses/{course}', [FrontendCourseController::class, 'show'])->name('course-details');

/**
 * SERVICES – FRONTEND
 */
Route::get('/services',           [FrontendServiceController::class, 'index'])->name('services');
Route::get('/services/{service}', [FrontendServiceController::class, 'show'])->name('service-details');

/**
 * TOPICES – FRONTEND
 */
Route::get('/topices',         [FrontendTopicesController::class, 'index'])->name('topices');
Route::get('/topices/{topic}', [FrontendTopicesController::class, 'show'])
    ->whereNumber('topic')->name('topices-details');

/**
 * VACANCIES – FRONTEND  (URL və adlar sabit)
 * index  => route('vacancies')
 * show   => route('vacancies-details')
 */
Route::get('/vacancies',           [FrontendVacanciesController::class, 'index'])->name('vacancies');
Route::get('/vacancies/{vacancy}', [FrontendVacanciesController::class, 'show'])
    ->whereNumber('vacancy')->name('vacancies-details');

/** Digər şablon səhifələr */
Route::view('/faqs', 'educve.faqs')->name('faqs');
Route::view('/error', 'educve.error')->name('error');


/** RESOURCES – FRONTEND */
Route::get('/resources', [FrontResourcesController::class, 'index'])->name('resources');
Route::get('/resources/{resource}', [FrontResourcesController::class, 'show'])->name('resources-details');



// Team – users
Route::get('/team',        [FrontTeam::class, 'index'])->name('team');
Route::get('/team/{team}', [FrontTeam::class, 'show'])->name('team-details');
// Route::view('/faqs', 'educve.faqs')->name('faqs');
Route::get('/faqss', [FrontendFaqController::class, 'index'])->name('faqss');


// About Us
Route::get('/about', AboutUsController::class)->name('about');

// AJAX üçün
Route::get('/search', [SearchController::class, 'search'])
    ->name('search');


// Subscribe / Unsubscribe
Route::post('/subscribe', [SubscribeController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('subscribe');

Route::get('/unsubscribe/{token}', [SubscribeController::class, 'unsubscribe'])
    ->name('unsubscribe');
