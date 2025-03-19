<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GraphController;

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

Route::resource('items', ItemController::class)
->middleware(['auth', 'verified']);

Route::resource('categories', CategoryController::class)
->middleware(['auth', 'verified']);

Route::get('chart', [ChartController::class, 'index'])
->middleware(['auth', 'verified'])->name('chart.index');
Route::get('daily', [ChartController::class, 'daily'])
->middleware(['auth', 'verified'])->name('chart.daily');
Route::get('category', [ChartController::class, 'category'])
->middleware(['auth', 'verified'])->name('chart.category');

//クエリテストコントローラ
Route::get('graph', [GraphController::class, 'graph'])
->middleware(['auth', 'verified'])->name('graph');

// //直接ダッシュボードページにアクセス
Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
