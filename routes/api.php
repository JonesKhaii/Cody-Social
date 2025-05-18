<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AIChatbotController;

Route::post('/upload-image', [ImageController::class, 'uploadImage']);

Route::middleware('auth:sanctum')->post('/posts/store', [PostController::class, 'store']);
Route::post('/ai-chatbot', [AIChatbotController::class, 'chat']);
