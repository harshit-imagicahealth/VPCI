<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WcConnectController;
use App\Http\Controllers\Admin\WcResourceController;
use App\Http\Controllers\AuthController;
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
    Route::get('live-session', function () {
        return view('Frontend.live-session');
    })->name('live-session');
    // Route::prefix('dr-spectra')->name('dr_spectra.')->group(function () {
    // Route::get('dashboard', [DRHomeController::class, 'index'])->name('dashboard');
    // Route::get('data', [DRHomeController::class, 'meetingData'])->name('dashboard.data');
    // Route::get('create', [DRHomeController::class, 'create'])->name('create');
    // Route::post('store', [DRHomeController::class, 'store'])->name('store');
    // Route::get('edit/{id}', [DRHomeController::class, 'edit'])->name('edit');
    // Route::post('update/{id}', [DRHomeController::class, 'update'])->name('update');
    // Route::post('delete/{id}', [DRHomeController::class, 'delete'])->name('delete');

    // Route::get('details/{id}', [DRHomeController::class, 'details'])->name('details');
    // Route::get('download-audio/{id}', [DRHomeController::class, 'downloadAudio'])->name('download-audio');
    // Route::post('photo-reupload', [DRHomeController::class, 'photoReupload'])->name('photo.reupload');
    // Route::post('audio-reupload', [DRHomeController::class, 'audioReupload'])->name('audio.reupload');
    // Route::get('download-video/{id}', [HomeController::class, 'downloadVideo'])->name('download.video');
    // });
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

        // Route::get('users-add', [AdminController::class, 'useradd'])->name('admin.user.add');
        // Route::post('users-store', [AdminController::class, 'userstore'])->name('admin.users.store');
        // Route::get('users-edit/{id}', [AdminController::class, 'useredit'])->name('admin.user.edit');
        // Route::post('users-update/{id}', [AdminController::class, 'userupdate'])->name('admin.users.update');
        // Route::delete('users/delete/{id}', [AdminController::class, 'userdelete'])->name('admin.user.delete');
        // Route::get('users-deleteall', [AdminController::class, 'deleteall'])->name('admin.user.deleteall');
        // Route::get('users-csv', [AdminController::class, 'usercsv'])->name('admin.user.csv');
        // Route::post('user/import', [AdminController::class, 'importUsers'])->name('admin.user.import');


        // Route::get('requestlist', [AdminController::class, 'requestlist'])->name('admin.requestlist');
        // Route::get('request-data', [AdminController::class, 'requestdata'])->name('admin.request.data');
        // Route::get('request/edit/{id}', [AdminController::class, 'requestedit'])->name('admin.request.edit');
        // Route::post('request/edit/update/{id}', [AdminController::class, 'editupdate'])->name('admin.request.edit.update');
        // Route::post('request/delete/{id}', [AdminController::class, 'requestdelete'])->name('admin.request.delete');
        // Route::get('request-csv', [AdminController::class, 'requestcsv'])->name('admin.request.csv');

        // Route::prefix('doctor')->name('admin.dr_spectra.')->group(function () {
        //     Route::get('requestlist', [DRAdminController::class, 'requestlist'])->name('request.list');
        //     Route::get('request-data', [DRAdminController::class, 'requestdata'])->name('request.data');
        //     // Route::get('request/edit/{id}', [DRAdminController::class, 'requestedit'])->name('request.edit');
        //     // Route::post('request/edit/update/{id}', [DRAdminController::class, 'editupdate'])->name('request.edit.update');
        //     Route::post('request/delete/{id}', [DRAdminController::class, 'requestdelete'])->name('request.delete');
        //     Route::get('request-csv', [DRAdminController::class, 'requestcsv'])->name('request.csv');
        //     Route::get('region-wise-csv', [DRAdminController::class, 'regionWisecsv'])->name('region.wise.csv');

        //     Route::get('employee-wise-csv', [DRAdminController::class, 'employeeWiseCsv'])->name('employee.wise.csv');

        // });
    });
});
