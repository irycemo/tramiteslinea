<?php

use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Auditoria;
use App\Livewire\Admin\Entidades;
use Illuminate\Support\Facades\Route;
use App\Livewire\Usuarios\Aviso\Avisos;
use App\Http\Middleware\VerifyCsrfToken;
use App\Livewire\Usuarios\Tramites\Nuevo;
use App\Http\Controllers\ManualController;
use App\Livewire\Usuarios\Aviso\MisAvisos;
use App\Livewire\Usuarios\Tramites\Tramites;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetPasswordController;
use App\Livewire\Usuarios\Tramites\Certificados;
use App\Http\Controllers\Sap\AcreditaPagoController;
use App\Livewire\Rpp\Tramites\Nuevo as TramitesNuevo;
use App\Livewire\Usuarios\Observaciones\Observaciones;
use App\Livewire\Rpp\Tramites\Tramites as TramitesTramites;
use App\Livewire\Usuarios\Usuarios as UsuariosUsuarios;

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

    /* CATASTRO */
    Route::get('aviso/{aviso?}', Avisos::class)->middleware('permission:Nuevo aviso')->name('aviso');

    Route::get('mis_avisos', MisAvisos::class)->middleware('permission:Mis avisos')->name('mis_avisos');

    Route::get('tramites', Tramites::class)->middleware('permission:Trámites')->name('tramites');

    Route::get('tramite_nuevo', Nuevo::class)->middleware('permission:Trámite nuevo')->name('tramite_nuevo');

    Route::get('certificados', Certificados::class)->middleware('permission:Certificados')->name('certificados');

    Route::get('observaciones', Observaciones::class)->middleware('permission:Observaciones')->name('observaciones');

    /* RPP */
    Route::get('tramites_rpp', TramitesTramites::class)->middleware('permission:Trámites rpp')->name('tramites_rpp');

    Route::get('tramite_nuevo_rpp', TramitesNuevo::class)->middleware('permission:Trámite nuevo rpp')->name('tramite_nuevo_rpp');

    Route::get('usuarios_notaria', UsuariosUsuarios::class)->middleware('permission:Usuarios notaria')->name('usuarios_notaria');

});

Route::post('acredita_pago', AcreditaPagoController::class)->name('acredita_pago');

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

Route::get('manual', ManualController::class)->name('manual');
