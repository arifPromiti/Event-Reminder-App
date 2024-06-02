<?php

use App\Http\Controllers\admin\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/active-articles', [ArticleController::class, 'activeArticleList']);
Route::get('/articles/data/{article_id}', [ArticleController::class, 'articleData']);
