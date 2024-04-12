<?php

use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Auditoria;
use App\Livewire\Admin\Entidades;
use Illuminate\Support\Facades\Route;
use App\Livewire\Usuarios\Aviso\Avisos;
use App\Http\Controllers\ManualController;
use App\Livewire\Usuarios\Tramites\Tramites;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetPasswordController;
use App\Livewire\Usuarios\Tramites\Certificados;
use App\Livewire\Usuarios\Tramites\Nuevo;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth', 'activo'])->group( function(){

    /* Administración */
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('entidades', Entidades::class)->middleware('permission:Lista de entidades')->name('entidades');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

    Route::get('aviso/{aviso?}', Avisos::class)->middleware('permission:Nuevo aviso')->name('aviso');

    Route::get('tramites', Tramites::class)->middleware('permission:Trámites')->name('tramites');

    Route::get('tramite_nuevo', Nuevo::class)->middleware('permission:Trámite nuevo')->name('tramite_nuevo');

    Route::get('certificados', Certificados::class)->middleware('permission:Certificados')->name('certificados');

});

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

Route::get('manual', ManualController::class)->name('manual');
