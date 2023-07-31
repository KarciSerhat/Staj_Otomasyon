<?php

use App\Models\Announcement;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Web\HomepageController;
use \App\Http\Controllers\Web\ApplicationController;
use \App\Http\Controllers\Web\NotificationController;
use \App\Http\Controllers\Web\Admin\AdminApplicationControlle;
use \App\Http\Controllers\Web\Admin\InternshipPeriodController;
use \App\Http\Controllers\Web\Admin\UygulamaController;
use \App\Http\Controllers\Web\Admin\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware('auth_cas')->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('homepage');
    Route::get('/notification/{link}/{id}', [NotificationController::class, 'index'])->name('notification');
    Route::post('/notification/remove/{id}', [NotificationController::class, 'remove'])->name('notification.remove');
    Route::post('/notification/clearAll', [NotificationController::class, 'clearAll'])->name('notification.clearAll');

    Route::get('documents', function () {
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
       return view('front.pages.internshipDoc', compact('announcements'));
    })->name('documents');

    Route::prefix('/application')->group(function (){
        Route::get('/',[ApplicationController::class, 'index'])->name('application');
        Route::post('/create',[ApplicationController::class, 'create'])->name('application.create');
        Route::post('/application/update',[ApplicationController::class, 'update'])->name('application.update');
        Route::get('/applications',[ApplicationController::class, 'applications'])->name('applications');
        Route::get('/getApplications',[ApplicationController::class, 'getApplications'])->name('getApplications');
        Route::get('/application/detail/{id}',[ApplicationController::class, 'getApplicationDetail'])->name('getApplicationDetail');
        Route::post('/application/send/document',[ApplicationController::class, 'sendDocument'])->name('sendDocument');
        Route::get('/application/get/document/{id}',[ApplicationController::class, 'getDocument'])->name('getDocument');
        Route::post('/application/download',[ApplicationController::class, 'documentDownload'])->name('documentDownload');
        Route::post('/application/internships/book',[ApplicationController::class, 'internshipsBook'])->name('internshipsBook');
    });

    Route::prefix('admin/')->middleware('isAdmin')->group(function () {
        Route::prefix('step')->group(function (){
            Route::get('/',[AdminApplicationControlle::class, 'index'])->name('admin.application');
            Route::get('/getApplications',[AdminApplicationControlle::class, 'getApplications'])->name('admin.getApplications');
            Route::get('/getAdminApplicationDetail/{id}',[AdminApplicationControlle::class, 'getAdminApplicationDetail'])->name('admin.getAdminApplicationDetail');
            Route::post('/step0',[AdminApplicationControlle::class, 'step0'])->name('admin.application.step0');
            Route::post('/step1',[AdminApplicationControlle::class, 'step1'])->name('admin.application.step1');
            Route::post('/step2',[AdminApplicationControlle::class, 'step2'])->name('admin.application.step2');
            Route::post('/step3',[AdminApplicationControlle::class, 'step3'])->name('admin.application.step3');
            Route::post('/step4',[AdminApplicationControlle::class, 'step4'])->name('admin.application.step4');
            Route::post('/step5',[AdminApplicationControlle::class, 'step5'])->name('admin.application.step5');
            Route::get('/get/document/{id}',[AdminApplicationControlle::class, 'getDocument'])->name('getDocument');
            Route::post('/download',[AdminApplicationControlle::class, 'documentDownload'])->name('documentDownload');

        });

        Route::prefix('internship/period')->group(function (){
            Route::get('/',[InternshipPeriodController::class, 'index'])->name('admin.internship.period');
            Route::get('/all',[InternshipPeriodController::class, 'getInternshipPeriods'])->name('getInternshipPeriods');
            Route::post('/create',[InternshipPeriodController::class, 'intershipCreate'])->name('admin.internship.period.create');
            Route::post('/update',[InternshipPeriodController::class, 'update'])->name('admin.internship.period.update');
            Route::get('/detail/{id}',[InternshipPeriodController::class, 'detail'])->name('admin.internship.period.detail');
            Route::get('/change/{id}',[InternshipPeriodController::class, 'change'])->name('admin.internship.period.change');

        });

        Route::prefix('uygulama')->group(function (){
            Route::get('/',[UygulamaController::class, 'index'])->name('admin.uygulama');
            Route::get('/all',[UygulamaController::class, 'getUygulama'])->name('getUygulama');
            Route::post('/create',[UygulamaController::class, 'uygulamaCreate'])->name('admin.uygulama.create');
            Route::post('/update',[UygulamaController::class, 'update'])->name('admin.uygulama.update');
            Route::get('/detail/{id}',[UygulamaController::class, 'detail'])->name('admin.uygulama.detail');
            Route::get('/change/{id}',[UygulamaController::class, 'change'])->name('admin.uygulama.change');
        });

        Route::prefix('announcement')->group(function (){
            Route::get('/',[AnnouncementController::class, 'index'])->name('admin.announcement');
            Route::get('/all',[AnnouncementController::class, 'getAnnouncement'])->name('getAnnouncement');
            Route::post('/create',[AnnouncementController::class, 'announcementCreate'])->name('admin.announcement.create');
            Route::post('/update',[AnnouncementController::class, 'update'])->name('admin.announcement.update');
            Route::get('/detail/{id}',[AnnouncementController::class, 'detail'])->name('admin.announcement.detail');
            Route::get('/change/{id}',[AnnouncementController::class, 'change'])->name('admin.announcement.change');
        });
    });
});
