<?php

use App\Http\Controllers\Admin\ActivityLiveQuestionController;
use App\Http\Controllers\Admin\ActivityQuestionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WcConnectController;
use App\Http\Controllers\Admin\WcResourceController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebinarController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('Frontend.home');
})->name('home');
Route::get('/about-us', function () {
    return view('Frontend.about-us');
})->name('about-us');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('live-session/{id?}', [WebinarController::class, 'index'])->name('live-session');
    Route::get('live-session/webinars/assessment', [AssessmentController::class, 'index'])->name('webinars.assessment');
    Route::post('live-session/webinars/assessment', [AssessmentController::class, 'store'])->name('webinars.assessment.store');
    Route::get('live-session/webinars/assessment/result', [AssessmentController::class, 'result'])->name('webinars.assessment.result');
    Route::get('live-session/webinars/assessment/certificate', function () {
        return view('Frontend.assessment.certificate');
    })->name('webinars.assessment.certificate');
    Route::get('live-session/webinars/{webcast_id}', [WebinarController::class, 'videoStream'])->name('webinars.videoStream');
    Route::post('track-video-complete', [WebinarController::class, 'trackVideoComplete'])->name('track-video-complete');
    Route::get('live-session/webinars/{type}/{webcast_id_pdf}', [WebinarController::class, 'pdfStream'])->name('webinars.pdfStream');
    Route::post('live-questions/submit', [ActivityLiveQuestionController::class, 'submitLiveQuestion'])->name('live.questions.submit');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'loginPost'])->name('admin.login.post');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('users', [AdminController::class, 'userlist'])->name('admin.users.index');
        Route::get('users-data', [AdminController::class, 'userdata'])->name('admin.users.list.data');

        // WebCast Connect
        Route::prefix('webcast-connect')->name('admin.wc_connect.')->group(function () {
            Route::get('/', [WcConnectController::class, 'index'])->name('index');
            Route::get('get-data', [WcConnectController::class, 'getData'])->name('list.data');
            Route::get('create', [WcConnectController::class, 'create'])->name('create');
            Route::post('store', [WcConnectController::class, 'store'])->name('store');
            Route::get('edit/{id}', [WcConnectController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [WcConnectController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [WcConnectController::class, 'destroy'])->name('delete');
        });
        Route::prefix('live-questions')->name('admin.live-questions.')->group(function () {
            Route::get('{activityId}',           [ActivityLiveQuestionController::class, 'index'])->name('index');
            Route::get('{activityId}/data',      [ActivityLiveQuestionController::class, 'listData'])->name('list.data');
            Route::post('{id}/mark-read',        [ActivityLiveQuestionController::class, 'markAsRead'])->name('mark.read');
            Route::post('{id}/mark-unread',      [ActivityLiveQuestionController::class, 'markAsUnread'])->name('mark.unread');
        });
        Route::prefix('webcast-resource')->name('admin.wc_resource.')->group(function () {
            Route::get('/', [WcResourceController::class, 'index'])->name('index');
            Route::get('get-data', [WcResourceController::class, 'getData'])->name('list.data');
            Route::get('create', [WcResourceController::class, 'create'])->name('create');
            Route::post('store', [WcResourceController::class, 'store'])->name('store');
            Route::get('edit/{id}', [WcResourceController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [WcResourceController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [WcResourceController::class, 'destroy'])->name('delete');
        });

        // Category Routes
        Route::prefix('categoty')->name('admin.category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('get-data', [CategoryController::class, 'categoryData'])->name('list.data');
            Route::get('create', [CategoryController::class, 'create'])->name('create');
            Route::post('store', [CategoryController::class, 'store'])->name('store');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        });

        // Questions Routes
        Route::name('admin.')->group(function () {
            Route::resource('questions', ActivityQuestionController::class)->except('show');
            Route::post('questions/{id}/toggle', [ActivityQuestionController::class, 'toggle']);
            Route::get('questions/list/data', [ActivityQuestionController::class, 'listData'])->name('questions.list.data');
        });
    });
});
