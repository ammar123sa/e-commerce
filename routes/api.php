<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CommentController ;
use App\Http\Controllers\RatingController ;
use App\Http\Controllers\ContactController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/contacts', [ContactController::class, 'store']);
});

//  Product
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/type/{type}', [ProductController::class, 'byType']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    // favorites
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{product}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy']);
    // order 
     Route::post('/orders', [OrderController::class, 'store']);
   // offer 
    Route::get('offers', [OfferController::class, 'index']);
    Route::get('offers/{id}', [OfferController::class, 'show']);
    // comment and rating 
    Route::get('/products/{product}/comments', [CommentController::class, 'index']);
    //Route::post('/comments', [CommentController::class, 'store']) ;

    Route::post('/ratings', [RatingController::class, 'store']);
    
    // admin products
    Route::middleware('admin')->group(function () {
         Route::post('offers', [OfferController::class, 'store']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        Route::delete('offers/{id}', [OfferController::class, 'destroy']);
        

    });
});

// imaage of product
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/products/{product}/images', [ProductImageController::class, 'store']);
    Route::delete('/products/{product}/images/{image}', [ProductImageController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);              
    Route::post('/cart/items', [CartController::class, 'store']);      
    Route::put('/cart/items/{item}', [CartController::class, 'update']); 
    Route::delete('/cart/items/{item}', [CartController::class, 'destroy']); 
});
// comments
Route::prefix('comments')->middleware('auth:sanctum')->group(function () {
    Route::get('/product/{productId}', [CommentController::class, 'index']); // جلب تعليقات منتج معيّن
    Route::post('/', [CommentController::class, 'store']);                    // إنشاء تعليق
    Route::put('/{id}', [CommentController::class, 'update']);               // تعديل تعليق
    Route::delete('/{id}', [CommentController::class, 'destroy']);           // حذف تعليق
});