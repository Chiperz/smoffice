<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DisplayProductController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\SubBrandProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
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

    Route::get('display/trashed', [DisplayProductController::class, 'trashed'])->name('display.trashed');
    Route::get('display/{id}/restore', [DisplayProductController::class, 'restore'])->name('display.restore');
    Route::delete('display/{id}/force-delete', [DisplayProductController::class, 'forceDelete'])->name('display.force-delete');
    Route::resource('display', DisplayProductController::class);

    Route::get('category/trashed', [CategoryProductController::class, 'trashed'])->name('category.trashed');
    Route::get('category/{id}/restore', [CategoryProductController::class, 'restore'])->name('category.restore');
    Route::delete('category/{id}/force-delete', [CategoryProductController::class, 'forceDelete'])->name('category.force-delete');
    Route::resource('category', CategoryProductController::class);

    Route::get('brand/trashed', [BrandProductController::class, 'trashed'])->name('brand.trashed');
    Route::get('brand/{id}/restore', [BrandProductController::class, 'restore'])->name('brand.restore');
    Route::delete('brand/{id}/force-delete', [BrandProductController::class, 'forceDelete'])->name('brand.force-delete');
    Route::resource('brand', BrandProductController::class);

    Route::get('sub-brand/trashed', [SubBrandProductController::class, 'trashed'])->name('sub-brand.trashed');
    Route::get('sub-brand/{id}/restore', [SubBrandProductController::class, 'restore'])->name('sub-brand.restore');
    Route::delete('sub-brand/{id}/force-delete', [SubBrandProductController::class, 'forceDelete'])->name('sub-brand.force-delete');
    Route::resource('sub-brand', SubBrandProductController::class);

    Route::get('product/trashed', [ProductController::class, 'trashed'])->name('product.trashed');
    Route::get('product/{id}/restore', [ProductController::class, 'restore'])->name('product.restore');
    Route::delete('product/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('product.force-delete');
    Route::resource('product', ProductController::class);

    Route::get('customer/{type}/trashed', [CustomerController::class, 'trashed'])->name('customer.trashed');
    Route::get('customer/{id}/{type}/restore', [CustomerController::class, 'restore'])->name('customer.restore');
    Route::delete('customer/{id}/{type}/force-delete', [CustomerController::class, 'forceDelete'])->name('customer.force-delete');
    Route::resource('customer', CustomerController::class);
});

require __DIR__.'/auth.php';
