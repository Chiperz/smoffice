<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PositionController;
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

Route::get('/', function () {
    // return view('welcome');
    return view('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('branch/trashed', [BranchController::class, 'trashed'])->name('branch.trashed');
    Route::get('branch/{id}/restore', [BranchController::class, 'restore'])->name('branch.restore');
    Route::delete('branch/{id}/force-delete', [BranchController::class, 'forceDelete'])->name('branch.force-delete');
    Route::resource('branch', BranchController::class);

    Route::get('position/trashed', [PositionController::class, 'trashed'])->name('position.trashed');
    Route::get('position/{id}/restore', [PositionController::class, 'restore'])->name('position.restore');
    Route::delete('position/{id}/force-delete', [PositionController::class, 'forceDelete'])->name('position.force-delete');
    Route::resource('position', PositionController::class);
});

require __DIR__.'/auth.php';
