<?php

use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Auditoria;
use App\Livewire\Admin\Entidades;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TramiteReciboController;

Route::group([], function(){

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('entidades', Entidades::class)->middleware('permission:Lista de entidades')->name('entidades');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

    Route::get('orden_pago', [TramiteReciboController::class, 'imprimir'])->name('orden_pago');

});