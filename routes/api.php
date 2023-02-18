<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CollageController;
use App\Http\Controllers\RatingLikeController;
use App\Http\Controllers\CommentLikeController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(CollageController::class)->group(function () {
    Route::post('/collages',  'search');
    Route::get('/collage/{collage:slug}', 'show');
});

Route::group(['prefix' => 'rating'], function () {
    Route::get('/{rating}', [RatingController::class, 'show']);
    Route::post('/', [RatingController::class, 'store']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::get('/{user}', [UserController::class, 'show']);
    });

    Route::group(['prefix' => 'rating'], function () {
        Route::delete('/{rating}', [RatingController::class, 'destroy']);
        Route::post('/{rating}/like', [RatingLikeController::class, 'create']);
        Route::delete('/{rating}/unlike', [RatingLikeController::class, 'destroy']);
    });

    Route::group(['prefix' => 'comment'], function () {
        Route::post('/{comment}/like', [CommentLikeController::class, 'create']);
        Route::delete('/{comment}/unlike', [CommentLikeController::class, 'destroy']);
    });

    Route::controller(AuthController::class)->group(function () {
        Route::get('/user', 'user');
        Route::post('/logout', 'logout');
    });
});
