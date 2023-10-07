<?php

use App\Http\Controllers\BorrowBookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPasswordController;
use App\Http\Controllers\UserVerificationController;
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

Route::permanentRedirect('home', '/');

Route::as('user-verification.')->controller(UserVerificationController::class)->group(function () {
    Route::get('user/{email}/{token}/verify', 'index')->name('index');
    Route::post('user/{email}/{token}/verify', 'store')->name('store');
});

Route::middleware(['verified', 'auth',])->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::view('/my/password', 'pages.user.password')->name('my-password');
    Route::view('/my/profile', 'pages.user.profile')->name('my-profile');

    Route::resource('roles', RoleController::class)->only('index', 'create');
    Route::as('permissions.')->controller(RolePermissionController::class)->group(function () {
        Route::get('roles/{role}/permissions', 'index')->name('index');
        Route::post('roles/{role}/activate-permissions', 'store')->name('store');
        Route::delete('roles/{role}/deactivate-permissions', 'destroy')->name('destroy');
    });

    Route::resource('users', UserController::class);
    Route::as('users.reset.')->controller(UserPasswordController::class)->group(function () {
        Route::get('users/{user}/password', 'show')->name('show');
        Route::put('users/{user}/password', 'update')->name('update');
    });

    Route::resource('modules', ModuleController::class)->only('index', 'store');

    Route::resource('members', MemberController::class);

    Route::resource('borrows', BorrowController::class);
    Route::resource('borrows.borrow_books', BorrowBookController::class)->only(['index', 'store']);

    Route::prefix('datatables')->as('datatables.')->group(
        base_path('routes/datatables.php'),
    );

    Route::resource('books', BookController::class);
});

// Route untuk Localization
if (file_exists(app_path('Http/Controllers/LocalizationController.php')))
{
    Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class , 'lang']);
}