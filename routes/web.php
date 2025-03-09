<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::resource('demo/items', ItemController::class)
->middleware(['auth', 'verified']);

Route::resource('demo/categories', CategoryController::class)
->middleware(['auth', 'verified']);

Route::get('demo/table', [ChartController::class, 'table'])
->middleware(['auth', 'verified'])->name('chart.table');
Route::get('demo/daily', [ChartController::class, 'daily'])
->middleware(['auth', 'verified'])->name('chart.daily');
Route::get('demo/category', [ChartController::class, 'category'])
->middleware(['auth', 'verified'])->name('chart.category');

// //直接ダッシュボードページにアクセス
Route::get('/demo', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/demo/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/demo/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/demo/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/demo/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
