<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DiseaseController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\Api\AdminController;



Route::get('/diseases', [DiseaseController::class, 'index']);
Route::get('/disease/{id}', [DiseaseController::class, 'show']);
Route::get('/search', [DiseaseController::class, 'search']);
Route::post('/diseases', [DiseaseController::class, 'store']);
Route::post('/experts/register', [ExpertController::class, 'register']);
Route::post('/experts/login', [ExpertController::class, 'login']);
Route::get('/experts/{id}/diseases', [DiseaseController::class, 'expertDiseases']);
Route::put('/disease/{id}', [DiseaseController::class, 'update']);
Route::delete('/disease/{id}', [DiseaseController::class, 'destroy']);

Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

Route::get('/admin/experts', [AdminController::class, 'experts']);
Route::delete('/admin/experts/{id}', [AdminController::class, 'deleteExpert']);

Route::get('/admin/diseases', [AdminController::class, 'diseases']);
Route::delete('/admin/diseases/{id}', [AdminController::class, 'deleteDisease']);