<?php

use App\Http\Controllers\Api\AnnouncementApiController;
use App\Http\Controllers\Api\CompanyApiController;
use App\Http\Controllers\Api\DateOfInternshipApiController;
use App\Http\Controllers\Api\InternshipDocumentes;
use App\Http\Controllers\Api\InternshipPeriotApiController;
use App\Http\Controllers\Api\StudentInfoApiController;
use App\Http\Controllers\Api\UserInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//Route::prefix('/v1')->middleware('auth_cas')->group(function (){
Route::prefix('/v1')->group(function (){
    Route::prefix('/announcement')->group(function (){
        Route::get('all',[AnnouncementApiController::class,'getAll']);
        Route::get('get',[AnnouncementApiController::class,'getAnnouncement']);
        Route::post('create',[AnnouncementApiController::class,'createAnnouncement']);
        Route::post('update',[AnnouncementApiController::class,'updateAnnouncement']);
        Route::post('delete',[AnnouncementApiController::class,'deleteAnnouncement']);
    });
    Route::prefix('/company')->group(function (){
        Route::get('all',[CompanyApiController::class,'getAll']);
        Route::get('get',[CompanyApiController::class,'getCompany']);
        Route::post('create',[CompanyApiController::class,'createCompany']);
        Route::post('update',[CompanyApiController::class,'updateCompany']);
        Route::post('delete',[CompanyApiController::class,'deleteCompany']);
        Route::get('student',[StudentInfoApiController::class,'getStudent']);
        Route::post('checkCompany',[CompanyApiController::class,'checkCompany']);

    });
    Route::prefix('/dateofintern')->group(function (){
        Route::get('all',[DateOfInternshipApiController::class,'getAll']);
        Route::get('get',[DateOfInternshipApiController::class,'getDateOfIntern']);
        Route::post('create',[DateOfInternshipApiController::class,'createDateOfIntern']);
        Route::post('update',[DateOfInternshipApiController::class,'updateDateOf']);
        Route::post('delete',[DateOfInternshipApiController::class,'deleteDateOfIntern']);
    });
    Route::prefix('/internshipperiot')->group(function (){
        Route::get('all',[InternshipPeriotApiController::class,'getAll']);
        Route::get('get',[InternshipPeriotApiController::class,'getPeriot']);
        Route::post('create',[InternshipPeriotApiController::class,'create']);
        Route::post('update',[InternshipPeriotApiController::class,'update']);
        Route::post('delete',[InternshipPeriotApiController::class,'delete']);
    });
    Route::prefix('/internshipdocument')->group(function (){
        Route::get('all',[InternshipDocumentes::class,'getAll']);
        Route::get('get',[InternshipDocumentes::class,'getDocuments']);
        Route::post('create',[InternshipDocumentes::class,'createDocuments']);
        Route::post('update',[InternshipDocumentes::class,'updateDocuments']);
        Route::post('delete',[InternshipDocumentes::class,'deleteDocuments']);
    });

    Route::prefix('/user')->group(function (){
        Route::get('info',[UserInformationController::class,'getUser']);
        Route::get('auth/check',[UserInformationController::class,'authCheck']);
    });

});



