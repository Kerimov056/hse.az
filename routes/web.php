<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\Admin\NewsController;

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TopicesController as AdminTopicesController;
use App\Http\Controllers\Admin\VacanciesController as AdminVacanciesController;
use App\Http\Controllers\NewsController as FrontendNewsController;
use App\Http\Controllers\CourseController as FrontendCourseController;
use App\Http\Controllers\ServiceController as FrontendServiceController;
use App\Http\Controllers\TopicesController as FrontendTopicesController;
use App\Http\Controllers\VacanciesController as FrontendVacanciesController;
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
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\Admin\CourseRegistrationAdminController;
use App\Http\Controllers\Admin\HeroButtonController;

use App\Http\Middleware\SetLocale;

/**
 * KÖK URL → default dilə yönləndir
 * Məs: "/" → "/az"
 */
Route::get('/', function () {
    return redirect('/' . config('app.locale'));
});

/**
 * İstəsən: "/admin" daxil olunsa, avtomatik "/{default}/admin" olsun
 */
Route::get('/admin', function () {
    return redirect('/' . config('app.locale') . '/admin');
});

/**
 * =====================
 * ADMIN ({locale?} ilə)
 * =====================
 */
Route::middleware(['auth', EnsureUserIsAdmin::class, SetLocale::class])
    ->prefix('{locale?}/admin')
    ->where(['locale' => 'az|en|ru'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('news', NewsController::class);
        Route::resource('courses', AdminCourseController::class);
        Route::resource('services', AdminServiceController::class);
        Route::resource('topices', AdminTopicesController::class);
        Route::resource('vacancies', AdminVacanciesController::class);
        Route::resource('resources', AdminResourcesController::class);
        Route::resource('resource-types', AdminResourceTypesController::class)
            ->only(['index', 'store', 'destroy', 'show']);
        Route::resource('accreditations', AccreditationController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('teams', TeamController::class);
        Route::resource('gallery-images', GalleryImageController::class);

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::post('uploads/trix', [UploadController::class, 'trix'])->name('uploads.trix');

         Route::get('/course-registrations', [CourseRegistrationAdminController::class, 'index'])
        ->name('course-registrations.index');

    Route::get('/course-registrations/{courseRegistration}', [CourseRegistrationAdminController::class, 'show'])
        ->name('course-registrations.show');

    Route::delete('/course-registrations/{courseRegistration}', [CourseRegistrationAdminController::class, 'destroy'])
        ->name('course-registrations.destroy');
    });

/**
 * ============================================
 * FRONTEND — {locale?} OPTIONAL prefix + SetLocale
 * ============================================
 */
Route::group([
    'prefix' => '{locale?}',
    'where' => ['locale' => 'az|en|ru'],
    'middleware' => [SetLocale::class],
], function () {
Route::get('/courses/{course}/register', [CourseRegistrationController::class, 'create'])
    ->name('courses.register');

Route::post('/courses/{course}/register', [CourseRegistrationController::class, 'store'])
    ->name('courses.register.store');
    Route::resource('hero-buttons', HeroButtonController::class)->names('admin.hero-buttons');


    /** AUTH: əsas auth route-u */
    Route::get('/auth/{tab?}', [AuthController::class, 'show'])
        ->whereIn('tab', ['login', 'register'])
        ->name('auth.show');

    /**
     * BURADA ƏLAVƏ ETDİK:
     * /{locale?}/login → GET (form)
     * /{locale?}/register → GET (register tab)
     */
    Route::get('/login', [AuthController::class, 'show'])
        ->defaults('tab', 'login')
        ->name('login');

    Route::get('/register', [AuthController::class, 'show'])
        ->defaults('tab', 'register')
        ->name('register');

    /** POST login/register/logout */
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');

    /** Köhnə yönləndirmələr (istəsən saxla) */
    Route::get('/signup', fn() => redirect()->route('auth.show', 'register'));
    Route::get('/signin', fn() => redirect()->route('auth.show', 'login'));

    /** Ana səhifə */
    Route::get('/', [HomeController::class, 'index'])->name('home');

    /** Tasks */
    Route::resource('tasks', TaskController::class);

    /** Statik səhifələr */
    Route::view('/blog-details', 'educve.blog-details')->name('blog-details');

    /** Contact */
    Route::view('/contact', 'educve.contact')->name('contact');
    Route::post('/contact', [ContactController::class, 'send'])
        ->middleware('throttle:5,1')
        ->name('contact.send');

    /** COURSES – FRONTEND */
    Route::get('/courses', [FrontendCourseController::class, 'index'])->name('courses-grid-view');
    Route::get('/courses/{course}', [FrontendCourseController::class, 'show'])->name('course-details');

    /** SERVICES – FRONTEND */
    Route::get('/services', [FrontendServiceController::class, 'index'])->name('services');
    Route::get('/services/{service}', [FrontendServiceController::class, 'show'])->name('service-details');

    /** NEWS – FRONTEND */
    Route::get('/news', [FrontendNewsController::class, 'index'])->name('news');
    Route::get('/news/{news}', [FrontendNewsController::class, 'show'])->name('news-details');


    /** TOPICES – FRONTEND */
    Route::get('/topices', [FrontendTopicesController::class, 'index'])->name('topices');
    Route::get('/topices/{topic}', [FrontendTopicesController::class, 'show'])
        ->whereNumber('topic')->name('topices-details');

    /** VACANCIES – FRONTEND */
    Route::get('/vacancies', [FrontendVacanciesController::class, 'index'])->name('vacancies');
    Route::get('/vacancies/{vacancy}', [FrontendVacanciesController::class, 'show'])
        ->whereNumber('vacancy')->name('vacancies-details');

    /** Digər şablon səhifələr */
    Route::view('/faqs', 'educve.faqs')->name('faqs');
    Route::view('/error', 'educve.error')->name('error');

    /** RESOURCES – FRONTEND */
    Route::get('/resources', [FrontResourcesController::class, 'index'])->name('resources');
    Route::get('/resources/{resource}', [FrontResourcesController::class, 'show'])->name('resources-details');

    /** Team – users */
    Route::get('/team', [FrontTeam::class, 'index'])->name('team');
    Route::get('/team/{team}', [FrontTeam::class, 'show'])->name('team-details');

    /** Faqs (controller versiyası) */
    Route::get('/faqss', [FrontendFaqController::class, 'index'])->name('faqss');

    /** About Us */
    Route::get('/about', AboutUsController::class)->name('about');

    /** AJAX */
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    /** Subscribe / Unsubscribe */
    Route::post('/subscribe', [SubscribeController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('subscribe');

    Route::get('/unsubscribe/{token}', [SubscribeController::class, 'unsubscribe'])
        ->name('unsubscribe');
});
