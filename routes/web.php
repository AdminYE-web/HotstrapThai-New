<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - HOT STRAP
|--------------------------------------------------------------------------
*/

// หน้าหลัก (Main Page)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// หน้าสินค้าทั้งหมด (All Products Page with Filter & Infinite Scroll)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{slug}/customize', [ProductController::class, 'customize'])->name('products.customize');

// ตะกร้าสินค้า (Shopping Cart)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/confirm-split/{id}', [CartController::class, 'confirmSplit'])->name('cart.confirm-split');
Route::post('/cart/toggle-select/{id?}', [CartController::class, 'toggleSelect'])->name('cart.toggle-select');
Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// หน้า Footer Component โดยเฉพาะ
Route::get('/footer', function () {
    return view('footer');
})->name('footer');

// Routes สำคัญสำหรับลิงก์ต่าง ๆ ใน Footer
Route::get('/contact', function () {
    return view('welcome');
})->name('contact');

use App\Http\Controllers\QuotationController;

// ใบเสนอราคา (Quotation Workflow)
Route::get('/quotation', [QuotationController::class, 'create'])->name('quotation');
Route::post('/quotation', [QuotationController::class, 'store'])->name('quotation.store');
Route::get('/quotation/{id}', [QuotationController::class, 'show'])->name('quotation.show');

use App\Http\Controllers\OrderController;
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

Route::get('/faq', function () {
    return view('welcome');
})->name('faq');

Route::get('/shipping', function () {
    return view('welcome');
})->name('shipping');

Route::get('/payment', function () {
    return view('welcome');
})->name('payment');

Route::get('/cancel-order', function () {
    return view('welcome');
})->name('cancel-order');

Route::get('/cookie-policy', function () {
    return view('welcome');
})->name('cookie-policy');

