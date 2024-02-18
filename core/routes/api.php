<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/check-user', [ApiController::class, 'verifyphone']);
Route::get('/type_colis',[ApiController::class, 'types_colis']);
Route::get('/programmes/{id}', [ApiController::class,'mission']);
Route::get('/{programmeId}/rdv',[ApiController::class,'programme']);
Route::get('/checkphone/{phonenumber}',[ApiController::class,'checkphone']);
Route::post('/savecolis',[ApiController::class,'savecolis']);
Route::get('/bilan/{id_chauffeur}',[ApiController::class,'bilanProgramme']);
Route::get('rdvdetail/{code}',[ApiController::class,'rdvDetails']);
