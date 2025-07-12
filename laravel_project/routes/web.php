<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/search-suggest', [DashboardController::class, 'searchSuggest']);
Route::get('/dashboard/export/excel', [DashboardController::class, 'exportExcel'])->name('export.excel');
Route::get('/dashboard/export/pdf', [DashboardController::class, 'exportPdf'])->name('export.pdf');

Route::get('/menu', function () {
    return view('user.menu');
})->name('user.menu');

Route::get('/order', function () {
    return view('user.order');
})->name('user.order');

Route::get('/promo', function () {
    return view('user.promo');
})->name('user.promo');

Route::get('/reservasi', function () {
    return view('user.reservasi');
})->name('user.reservasi');

$disable_profile_auth = false; // Ubah ke true jika ingin profile tanpa login
if (!$disable_profile_auth) {
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
} else {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::resource('categories', CategoryController::class);
Route::resource('tables', TableController::class);
Route::resource('menu_items', MenuItemController::class)->middleware('auth', 'role:admin');
Route::resource('orders', OrderController::class);
Route::resource('promotions', PromotionController::class);
Route::resource('reviews', ReviewController::class);

Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');

Route::get('menu_items/{id}/edit-promotions', [App\Http\Controllers\MenuItemController::class, 'editPromotions'])->name('menu_items.editPromotions');
Route::put('menu_items/{id}/update-promotions', [App\Http\Controllers\MenuItemController::class, 'updatePromotions'])->name('menu_items.updatePromotions');

Route::get('promotions/{id}/edit-menus', [App\Http\Controllers\PromotionController::class, 'editMenus'])->name('promotions.editMenus');
Route::put('promotions/{id}/update-menus', [App\Http\Controllers\PromotionController::class, 'updateMenus'])->name('promotions.updateMenus');

require __DIR__.'/auth.php';
