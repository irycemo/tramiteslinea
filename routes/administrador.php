<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TramiteReciboController;
use App\Livewire\Admin\Auditoria;
use App\Livewire\Admin\Avisos\Avisos;
use App\Livewire\Admin\Avisos\VerAviso;
use App\Livewire\Admin\CuotasMinimas;
use App\Livewire\Admin\Entidades;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Usuarios;
use Illuminate\Support\Facades\Route;

Route::group([], function(){

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('entidades', Entidades::class)->middleware('permission:Lista de entidades')->name('entidades');

    Route::get('lista_avisos', Avisos::class)->middleware('permission:Lista de avisos')->name('lista_avisos');

    Route::get('ver_aviso/{aviso}', VerAviso::class)->middleware('permission:Ver aviso')->name('ver_aviso');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

    Route::get('orden_pago', [TramiteReciboController::class, 'imprimir'])->name('orden_pago');

    Route::get('cuotas_minimas', CuotasMinimas::class)->middleware('permission:Cuotas minimas')->name('cuotas_minimas');

});