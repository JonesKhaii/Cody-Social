<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;

Route::post('/upload-image', [ImageController::class, 'uploadImage']);

Route::middleware('auth:sanctum')->post('/posts/store', [PostController::class, 'store']);
