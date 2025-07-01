<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Controllers\AcreditarPagoController;

Route::get('/', function () {
    return redirect('login');
});

Route::post('acredita_pago', AcreditarPagoController::class)->name('acredita_pago');

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

Route::get('manual', ManualController::class)->name('manual');
