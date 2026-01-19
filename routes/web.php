<?php

use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Yajra\UserController as YajraUserController;  // class-based
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Yajra\UserBuilderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /**
     * role resource route
     */
    Route::get('roles/list', [RoleController::class, 'listTable'])->name('roles.list');
    Route::resource('roles', RoleController::class);

    // relationship route
    Route::get('/categories', [ProductController::class, 'categories']);
    Route::get('/products/by-category/{id}', [ProductController::class, 'productsByCategory']);

    /** 
     * product resource route
     */
    Route::middleware(['web', 'auth', 'can:view-product'])->group(function () {
        Route::resource('products', ProductController::class);
    });



    /**
     * user resource route
     * MANUAL DATATABLE
     */
    Route::get('users/list', [UserController::class, 'listTable'])->name('users.list');
    Route::resource('users', UserController::class);

    // CLASS BASED YAJRA
    Route::get('yajra/users', [UserBuilderController::class, 'index'])->name('yajra.users.index');

});

require __DIR__ . '/auth.php';




// Route::resource('users', UserController::class);
// Route::resource('users', UserController::class)->except(['show']);

// Route::get('/users/list', [UserController::class, 'yajra'])->name('users.list');
// Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
// Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
// Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
// Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
// Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
// Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
