<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  Route::get('login', [AuthController::class, 'login'])->name('login');
  Route::post('login', [AuthController::class, 'storeLogin'])->name('store.login');
});

Route::middleware('auth')->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('index');
  Route::get('/dataPresences', [DashboardController::class, 'dataPresences'])->name('dataPresences');
  Route::get('profile', [AuthController::class, 'profile'])->name('profile');
  Route::put('updateProfile/{id_user}', [AuthController::class, 'updateProfil'])->name('updateProfil');
  Route::put('updatePassword/{id_user}', [AuthController::class, 'updatePassword'])->name('updatePassword');
  Route::patch('resetPassword/{id_user}', [AuthController::class, 'resetPassword'])->name('resetPassword');
  Route::post('logout', [AuthController::class, 'logout'])->name('logout');

  Route::prefix('presences')->name('presences.')->group(function () {
    Route::patch('/out', [PresenceController::class, 'presenceOut'])->name('out');
    Route::get('/', [PresenceController::class, 'index'])->name('index');
    Route::post('/', [PresenceController::class, 'store'])->name('store');
    Route::get('/create', [PresenceController::class, 'create'])->name('create');
    Route::get('/{presence}/edit', [PresenceController::class, 'edit'])->name('edit');
    Route::put('/{presence}', [PresenceController::class, 'update'])->name('update');
    Route::delete('/{presence}', [PresenceController::class, 'destroy'])->name('destroy');
    Route::get('datatablePresences', [PresenceController::class, 'indexDatatable'])->name('datatable');
  });

  Route::middleware('role:Admin')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
      Route::get('/', [UserController::class, 'index'])->name('index');
      Route::post('/', [UserController::class, 'store'])->name('store');
      Route::get('/create', [UserController::class, 'create'])->name('create');
      Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
      Route::put('/{user}', [UserController::class, 'update'])->name('update');
      Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
      Route::get('datatableUsers', [UserController::class, 'indexDatatable'])->name('datatable');
    });

    Route::prefix('roles')->name('roles.')->group(function () {
      Route::get('/', [RoleController::class, 'index'])->name('index');
      Route::post('/', [RoleController::class, 'store'])->name('store');
      Route::get('/create', [RoleController::class, 'create'])->name('create');
      Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
      Route::put('/{role}', [RoleController::class, 'update'])->name('update');
      Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
      Route::get('datatableRoles', [RoleController::class, 'indexDatatable'])->name('datatable');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
      Route::get('/', [SettingController::class, 'index'])->name('index');
      Route::get('/{setting}/edit', [SettingController::class, 'edit'])->name('edit');
      Route::put('/{setting}', [SettingController::class, 'update'])->name('update');
      Route::get('datatableSettings', [SettingController::class, 'indexDatatable'])->name('datatable');
    });
  });
});

Route::fallback(function () {
  return abort(404, 'Page not found');
});
