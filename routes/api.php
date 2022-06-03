<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api', 'auth.jwt']], function(){
    Route::post('offers', [OfferController::class,'save']);
    Route::put('offers/{id}', [OfferController::class,'update']);
    Route::delete('offers/{id}', [OfferController::class,'delete']);


    Route::put('appointments/book/{id}', [AppointmentController::class, 'bookAppointment']);
    Route::delete('appointments/delete/{id}', [AppointmentController::class, 'deleteAppointment']);

    Route::post('comments', [CommentController::class, 'createComment']);
    Route::post('comments/delete/{id}', [CommentController::class, 'deleteComment']);

    Route::post('users', [UserController::class, 'createUser']);

});

Route::get('offers/{id}', [OfferController::class,'findById']);
Route::get('users/{id}', [UserController::class, 'findUserById']);
Route::get('appointments/{userId}', [AppointmentController::class, 'getAppointmentsFromUser']);

Route::get('offers',[OfferController::class,'index']);
Route::get('offers/search/{searchTerm}', [OfferController::class,'findBySearchTerm']);

Route::post('auth/login', [AuthController::class,'login']);



