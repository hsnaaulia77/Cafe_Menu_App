use App\Http\Controllers\Admin\DashboardController;

Route::get('/admin/dashboard', [DashboardController::class, 'index']);
