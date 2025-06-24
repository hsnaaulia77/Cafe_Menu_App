<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    // Admin routes
    Route::middleware(['auth', 'checkrole:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Menu management dengan permission dan audit logging
        Route::middleware(['permission:menu.read', 'audit.log:menu.read,info'])->group(function () {
            Route::get('menus/analytics', [App\Http\Controllers\Admin\MenuController::class, 'analytics'])->name('menus.analytics');
            Route::post('menus/bulk-update', [App\Http\Controllers\Admin\MenuController::class, 'bulkUpdate'])->name('menus.bulk-update');
            Route::get('menus/export', [App\Http\Controllers\Admin\MenuController::class, 'export'])->name('menus.export');
            Route::post('menus/import', [App\Http\Controllers\Admin\MenuController::class, 'import'])->name('menus.import');
            Route::resource('menus', App\Http\Controllers\Admin\MenuController::class);
            Route::post('menu/upload-gambar', [App\Http\Controllers\Admin\MenuController::class, 'uploadGambar'])->name('menu.upload_gambar');
        });
        
        // Kategori menu dengan permission
        Route::middleware(['permission:menu.read'])->group(function () {
            Route::resource('kategori-menu', App\Http\Controllers\Admin\KategoriMenuController::class)->names('kategori_menu');
        });
        
        // User management dengan permission dan audit logging
        Route::middleware(['permission:user.read', 'audit.log:user.read,warning'])->group(function () {
            Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names('users');
            Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::post('users/bulk-action', [App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('users.bulk-action');
            Route::get('users/export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
            Route::post('users/import', [App\Http\Controllers\Admin\UserController::class, 'import'])->name('users.import');
            Route::post('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
        });
        
        // Order management dengan permission dan audit logging
        Route::middleware(['permission:order.read', 'audit.log:order.read,info'])->group(function () {
            Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->names('orders');
            Route::post('orders/bulk-action', [\App\Http\Controllers\Admin\OrderController::class, 'bulkAction'])->name('orders.bulk-action');
            Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
            Route::patch('orders/{order}/paid', [\App\Http\Controllers\Admin\OrderController::class, 'markAsPaid'])->name('orders.mark-paid');
            Route::get('orders-dashboard', [\App\Http\Controllers\Admin\OrderController::class, 'dashboard'])->name('orders.dashboard');
            Route::get('orders/{order}/print', [\App\Http\Controllers\Admin\OrderController::class, 'print'])->name('orders.print');
            Route::get('orders/export/excel', [\App\Http\Controllers\Admin\OrderController::class, 'exportExcel'])->name('orders.export.excel');
            Route::get('orders/export/csv', [\App\Http\Controllers\Admin\OrderController::class, 'exportCsv'])->name('orders.export.csv');
            Route::get('orders/export/pdf', [\App\Http\Controllers\Admin\OrderController::class, 'exportPdf'])->name('orders.export.pdf');
        });
        
        // Promo management dengan permission
        Route::middleware(['permission:menu.read'])->group(function () {
            Route::resource('promos', App\Http\Controllers\Admin\PromoController::class)->names('promos');
        });
        
        // Security routes dengan audit logging
        Route::prefix('security')->name('security.')->middleware(['permission:system.audit', 'audit.log:system.audit,warning'])->group(function () {
            Route::get('/', [SecurityController::class, 'dashboard'])->name('dashboard');
            Route::get('/audit-logs', [SecurityController::class, 'auditLogs'])->name('audit-logs');
            Route::get('/sessions', [SecurityController::class, 'userSessions'])->name('sessions');
            Route::post('/sessions/{session}/terminate', [SecurityController::class, 'terminateSession'])->name('terminate-session');
            Route::post('/users/{user}/terminate-sessions', [SecurityController::class, 'terminateAllUserSessions'])->name('terminate-all-sessions');
            Route::post('/users/{user}/unlock', [SecurityController::class, 'unlockUser'])->name('unlock-user');
            Route::post('/users/{user}/force-password-change', [SecurityController::class, 'forcePasswordChange'])->name('force-password-change');
            Route::get('/stats', [SecurityController::class, 'getStats'])->name('stats');
            Route::get('/export-audit-logs', [SecurityController::class, 'exportAuditLogs'])->name('export-audit-logs');
        });
    });

    // Customer routes
    Route::middleware(['auth', 'checkrole:customer'])->group(function () {
        Route::get('dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('orders/create', [\App\Http\Controllers\Customer\OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [\App\Http\Controllers\Customer\OrderController::class, 'store'])->name('orders.store');
        // Form Checkout/Review Pesanan
        Route::get('orders/checkout', [\App\Http\Controllers\Customer\OrderController::class, 'checkout'])->name('orders.checkout');
        // Form Riwayat Pesanan
        Route::get('orders/history', [\App\Http\Controllers\Customer\OrderController::class, 'history'])->name('orders.history');
        // Form Profil Customer
        Route::get('profile', [\App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [\App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
        
        Route::middleware(['permission:menu.read'])->group(function () {
            Route::get('menu', [App\Http\Controllers\Admin\MenuController::class, 'userIndex'])->name('menu.browse');
        });
        
        Route::middleware(['permission:order.read'])->group(function () {
            Route::resource('cart', App\Http\Controllers\CartController::class);
            Route::resource('orders', App\Http\Controllers\OrderController::class);
        });
    });

    // Cashier routes
    Route::middleware(['auth', 'checkrole:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('dashboard', [CashierDashboardController::class, 'index'])->name('dashboard');
        Route::get('orders', [\App\Http\Controllers\Cashier\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}/payment', [\App\Http\Controllers\Cashier\OrderController::class, 'payment'])->name('orders.payment');
        Route::post('orders/{order}/pay', [\App\Http\Controllers\Cashier\OrderController::class, 'pay'])->name('orders.pay');
        Route::get('orders/manual/create', [\App\Http\Controllers\Cashier\OrderController::class, 'createManual'])->name('orders.create_manual');
        Route::post('orders/manual', [\App\Http\Controllers\Cashier\OrderController::class, 'storeManual'])->name('orders.store_manual');
        Route::get('orders/{order}/print', [\App\Http\Controllers\Cashier\OrderController::class, 'print'])->name('orders.print');
        Route::get('transactions/history', [\App\Http\Controllers\Cashier\OrderController::class, 'history'])->name('transactions.history');
    });
});

require __DIR__.'/auth.php';
