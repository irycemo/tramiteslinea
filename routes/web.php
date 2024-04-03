<?php

use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Auditoria;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Middleware\EstaActivoMiddleware;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth', 'activo'])->group( function(){

    /* Administración */
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

});

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

Route::get('manual', ManualController::class)->name('manual');
