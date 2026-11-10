<?php

use App\Models\Aviso;
use App\Models\User;
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

Artisan::command('usuarios', function(){

    $usuarios = User::all();

    foreach ($usuarios as $usuario) {

        if($usuario->hasRole('Administrador')) continue;

        $usuario->update(['estado' => 'inactivo']);

    }

});

Artisan::command('notaria', function(){

    $count = 0;

    $avisos = Aviso::with('predio', 'antecedentes')->whereHas('entidad', function($q){
                        $q->where('numero_notaria', 48);
                    })
                    ->where('estado', 'operado')
                    ->get();

    $progressbar = $this->output->createProgressBar($avisos->count());

    $progressbar->start();

    $handle = fopen(storage_path('app/public/not_48.csv'), 'w');

    foreach($avisos as $aviso){

        fputcsv($handle,[
            $aviso->folioAviso(),
            $aviso->created_at,
            $aviso->predio->cuentaPredial(),
            $aviso->predio->claveCatastral(),
            $aviso->predio->nombre_vialidad . ' ' . $aviso->predio->nombre_asentamiento . ' ' . $aviso->predio->numero_exterior . ' ' . $aviso->predio->numero_exterior_2 . ' ' . $aviso->predio->numero_interior . ' ' . $aviso->predio->numero_adicional . ' ' . $aviso->predio->codigo_postal,
            $aviso->predio->superficie_total_terreno,
            $aviso->predio->superficie_total_construccion,
            $aviso->antecedentes->first()->tomo,
            $aviso->antecedentes->first()->registro,
            $aviso->numero_escritura,
            $aviso->predio->valor_catastral,
            $aviso->valor_isai,
        ]);

    }

    rewind($handle);

    fclose($handle);

    $progressbar->finish();

    $this->info($count);

});
