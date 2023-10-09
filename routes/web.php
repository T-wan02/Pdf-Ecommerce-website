<?php

use App\Http\Controllers\Api\OrderApi;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [PageController::class, 'home']);

Route::get("/cart", [PageController::class, 'showCart']);
Route::post('/api/add-to-cart', [CartController::class, 'addToCart'])->name('order.add_to_cart');
Route::post('/api/remove-cart', [CartController::class, 'removeCart'])->name('order.remove_cart');

// checkout
Route::get('/api/checkout/getCartToken', [OrderController::class, 'getCartToken']);
Route::get('/checkout', [OrderController::class, 'showCheckout']);
Route::post('/checkout', [OrderController::class, 'checkout']);

Route::get('/download-pdf', [OrderController::class, 'downloadPdf'])->name('download.pdf');
Route::get('/receipt/{cartToken}/download/{filename}', [OrderController::class, 'download']);

Route::get('/receipt', [OrderController::class, 'showReceipt']); // This is where show receipt and download pdf file

// Route::get("/p/{slug}", [PageController::class, 'productDetail']);
