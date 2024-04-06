<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_all_invoice', [InvoicesController::class,'get_all_invoice']);
Route::get('/search_invoice', [InvoicesController::class,'search_invoice']);
Route::get('/create_invoice', [InvoicesController::class,'create_invoice']);
Route::get('/customers', [CustomersController::class,'all_customer']);
Route::get('/products', [ProductController::class,'all_product']);
Route::post('/add_invoice', [InvoicesController::class,'add_invoice']);
Route::get('/show_invoice/{id}', [InvoicesController::class,'show_invoice']);
