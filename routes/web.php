<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;

Auth::routes();

Route::get('/', function () {
    return redirect('/admin');
});

// Admin group: auth + admin middleware
Route::prefix('admin')->middleware(['auth','admin'])->group(function () {

    Route::get('/', function () {
        return redirect('/admin/posts/all');
    });

    // POSTS
    Route::prefix('posts')->name('admin.posts.')->group(function () {
        Route::get('all', [PostController::class, 'index'])->name('all');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::get('edit/{post}', [PostController::class, 'edit'])->name('edit'); // route model binding
        Route::post('save', [PostController::class, 'save'])->name('save'); // used for both create & update
        Route::get('delete/{post}', [PostController::class, 'destroy'])->name('delete');
    });

    // CATEGORIES
    Route::prefix('categories')->name('admin.categories.')->group(function () {
        Route::get('all', [CategoryController::class, 'index'])->name('all');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('save', [CategoryController::class, 'save'])->name('save');
        Route::get('delete/{category}', [CategoryController::class, 'destroy'])->name('delete');
    });
});

// Fallback route (custom 404 view)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
