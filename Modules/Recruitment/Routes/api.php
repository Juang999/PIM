<?php

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

Route::prefix('recruitment')->middleware('jwt.verify')->group(function () {
    Route::controller(Api\SubmissionController::class)->prefix('submission')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{rekrutPengajuan}', 'show');
        Route::put('/{rekrutPengajuan}', 'update');
    });
});
