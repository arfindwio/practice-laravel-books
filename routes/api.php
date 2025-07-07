<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;

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

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Categories
Route::get('/categories', [CategoryController::class, 'getCategories']);
Route::get('/categories/{id}', [CategoryController::class, 'getCategory']);

// Books
Route::get('/books', [BookController::class, 'getBooks']);
Route::get('/books/{id}', [BookController::class, 'getBook']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/authenticate',     [AuthController::class, 'authenticate']);
    Route::post('/logout',[AuthController::class, 'logout']);

    // Categories
    Route::post('/categories', [CategoryController::class, 'postCategory']);
    Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

    // Books
    Route::post('/books',        [BookController::class, 'postBook']);
    Route::put('/books/{id}',    [BookController::class, 'updateBook']);
    Route::delete('/books/{id}', [BookController::class, 'deleteBook']);
});


