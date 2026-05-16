<?php

use App\Models\Aviso;
use App\Services\PeritosExternosService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('avaluos', function(){

    $count = 0;

    $avisos = Aviso::with('entidad')->whereNotNull('avaluo_spe')->where('estado', '!=', 'operado')->get();

    $progressbar = $this->output->createProgressBar($avisos->count());

    $progressbar->start();

    foreach($avisos as $aviso){

        try {

            (new PeritosExternosService())->asociarAvaluo($aviso->avaluo_spe, $aviso->entidad->nombre());

            $progressbar->advance();

            $count ++;

        } catch (\Throwable $th) {
            $this->info($th->getMessage());

        }

    }

    $progressbar->finish();

    $this->info($count);

});