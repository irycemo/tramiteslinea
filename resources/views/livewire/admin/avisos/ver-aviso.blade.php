<div>

    <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Aviso <span class="text-base">({{ $aviso->tipo }})</span></h1>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Datos generales</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600 flex gap-5 justify-end">

        @if($aviso->tramite_sgc)

            <x-button-blue
                wire:click="verTramiteAviso"
                wire:target="verTramiteAviso"
                wire:loading.attr="disabled">

                <img wire:loading wire:target="verTramiteAviso" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Trámite
            </x-button-blue>

        @endif

        @if($aviso->certificado_sgc)

            <x-button-gray
                wire:click="reimprimirCertificado"
                wire:target="reimprimirCertificado"
                wire:loading.attr="disabled">

                <img wire:loading wire:target="reimprimirCertificado" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Certificado
            </x-button-gray>

        @endif

        @if($aviso->avaluo_spe)

            <x-button-red
                wire:click="imprimirAvaluo"
                wire:target="imprimirAvaluo"
                wire:loading.attr="disabled">

                <img wire:loading wire:target="imprimirAvaluo" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Avalúo
            </x-button-red>

        @endif

        @if($aviso->avaluo_spe)

            <x-link-green
                href="{{ Storage::disk('avisos')->url($aviso->archivo()->first()->url) }}"
                target="_blank"
                >
                Archivo
            </x-link-green>

        @endif

    </div>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Folio</strong>

                <p>{{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Estado</strong>

                <p>{{ ucfirst($aviso->estado) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Acto</strong>

                <p>{{ $aviso->acto }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha ejecutoria</strong>

                <p>{{ $aviso->fecha_ejecutoria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de escritura</strong>

                <p>{{ $aviso->tipo_escritura }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número de escritura</strong>

                <p>{{ $aviso->numero_escritura }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Volúmen de escritura</strong>

                <p>{{ $aviso->volumen_escritura }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Lugar de otorgamiento</strong>

                <p>{{ $aviso->lugar_otorgamiento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de otorgamiento</strong>

                <p>{{ $aviso->fecha_otorgamiento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Lugar de firma</strong>

                <p>{{ $aviso->lugar_firma }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de firma</strong>

                <p>{{ $aviso->fecha_firma }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cantidad tramitada</strong>

                <p>{{ $aviso->cantidad_tramitada }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2 col-span-5">

                <strong>Observaciones</strong>

                <p>{{ $aviso->observaciones }}</p>

            </div>

        </div>

    </div>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de adquisición</strong>

                <p>{{ $aviso->valor_adquisicion }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de reducción</strong>

                <p>{{ $aviso->fecha_reduccion }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de construcción de vivienda</strong>

                <p>{{ $aviso->valor_construccion_vivienda }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de construcción otro</strong>

                <p>{{ $aviso->valor_construccion_otro }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Porcentaje de adquisición</strong>

                <p>{{ $aviso->porcentaje_adquisicion }} %</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Reducción</strong>

                <p>{{ $aviso->reduccion }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Base gravable</strong>

                <p>{{ $aviso->base_gravable }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor base</strong>

                <p>{{ $aviso->valor_base }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de ISAI</strong>

                <p>{{ $aviso->valor_isai }}</p>

            </div>

        </div>

    </div>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuenta predial</strong>

                <p>{{ $predio->cuentaPredial() }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clave catastral</strong>

                <p>{{ $predio->claveCatastral() }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie notarial</strong>

                <p>{{ number_format($predio->superficie_notarial, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie judicial</strong>

                <p>{{ number_format($predio->superficie_judicial, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie total de terreno</strong>

                <p>{{ number_format($predio->superficie_total_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor total de terreno</strong>

                <p>{{ number_format($predio->valor_total_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie total de construcción</strong>

                <p>{{ number_format($predio->superficie_total_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor total de construcción</strong>

                <p>{{ number_format($predio->valor_total_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor catastral</strong>

                <p>${{ number_format($predio->valor_catastral, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Uso del predio</strong>

                <p>Uso 1: {{ $predio->uso_1 }}</p>
                <p>Uso 2: {{ $predio->uso_2 }}</p>
                <p>Uso 3: {{ $predio->uso_3 }}</p>

            </div>

        </div>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Ubicación del predio</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de asentamiento</strong>

                <p>{{ $predio->tipo_asentamiento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Nombre del asentamiento</strong>

                <p>{{ $predio->nombre_asentamiento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de vialidad</strong>

                <p>{{ $predio->tipo_vialidad }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Nombre de la vialidad</strong>

                <p>{{ $predio->nombre_vialidad }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número exterior</strong>

                <p>{{ $predio->numero_exterior }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número exterior 2</strong>

                <p>{{ $predio->numero_exterior_2 }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número interior</strong>

                <p>{{ $predio->numero_interior }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número adicional</strong>

                <p>{{ $predio->numero_adicional }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número adicional 2</strong>

                <p>{{ $predio->numero_adicional_2 }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Código postal</strong>

                <p>{{ $predio->codigo_postal }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Lote del fraccionador</strong>

                <p>{{ $predio->lote_fraccionador }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Manzana del fraccionador</strong>

                <p>{{ $predio->manzana_fraccionador }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Etapa o zona del fraccionador</strong>

                <p>{{ $predio->etapa_fraccionador }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Nombre del Edificio</strong>

                <p>{{ $predio->nombre_edificio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clave del edificio</strong>

                <p>{{ $predio->clave_edificio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Departamento</strong>

                <p>{{ $predio->departamento_edificio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Predio Rústico Denominado ó Antecedente</strong>

                <p>{{ $predio->nombre_predio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Ubicación en manzana</strong>

                <p>{{ $predio->ubicacion_en_manzana }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Coordenadas geográficas UTM</strong>

                <p>X: {{ $predio->xutm }}</p>
                <p>Y: {{ $predio->yutm }}</p>
                <p>Z: {{ $predio->zutm }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Coordenadas geográficas GEO</strong>

                <p>Lat: {{ $predio->lat }}</p>
                <p>Lon: {{ $predio->lon }}</p>

            </div>

        </div>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Colindancias ({{ $predio->colindancias->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider">

                    <th class="px-2">Viento</th>
                    <th class="px-2">Longitud(mts.)</th>
                    <th class="px-2">Descripción</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->colindancias as $colindancia)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full">{{ $colindancia->viento }}</td>
                        <td class=" px-2 w-full">{{ $colindancia->longitud }}</td>
                        <td class=" px-2 w-full">{{ $colindancia->descripcion }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Transmitentes ({{ $predio->transmitentes()->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Tipo de persona</th>
                    <th class="px-2">Nombre / Razón social</th>
                    <th class="px-2">Porcentaje de propiedad</th>
                    <th class="px-2">Porcentaje de nuda</th>
                    <th class="px-2">Porcentaje de usufructo</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->transmitentes()->sortBy('persona.nombre') as $transmitente)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $transmitente->persona->tipo }}</td>
                        <td class=" px-2 w-full ">{{ $transmitente->persona->nombre }} {{ $transmitente->persona->ap_paterno }} {{ $transmitente->persona->ap_materno }} {{ $transmitente->persona->razon_social }}</td>
                        <td class=" px-2 w-full ">{{ $transmitente->porcentaje_propiedad }}%</td>
                        <td class=" px-2 w-full ">{{ $transmitente->porcentaje_nuda }}%</td>
                        <td class=" px-2 w-full ">{{ $transmitente->porcentaje_usufructo }}%</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Adquirientes ({{ $predio->adquirientes()->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Tipo de persona</th>
                    <th class="px-2">Nombre / Razón social</th>
                    <th class="px-2">Porcentaje de propiedad</th>
                    <th class="px-2">Porcentaje de nuda</th>
                    <th class="px-2">Porcentaje de usufructo</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->adquirientes()->sortBy('persona.nombre') as $adquiriente)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $adquiriente->persona->tipo }}</td>
                        <td class=" px-2 w-full ">{{ $adquiriente->persona->nombre }} {{ $adquiriente->persona->ap_paterno }} {{ $adquiriente->persona->ap_materno }} {{ $adquiriente->persona->razon_social }}</td>
                        <td class=" px-2 w-full ">{{ $adquiriente->porcentaje_propiedad }}%</td>
                        <td class=" px-2 w-full ">{{ $adquiriente->porcentaje_nuda }}%</td>
                        <td class=" px-2 w-full ">{{ $adquiriente->porcentaje_usufructo }}%</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Fideicomitentes ({{ $predio->fideicomitentes()->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Tipo de persona</th>
                    <th class="px-2">Nombre / Razón social</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->fideicomitentes()->sortBy('persona.nombre') as $fideicomitente)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $fideicomitente->persona->tipo }}</td>
                        <td class=" px-2 w-full ">{{ $fideicomitente->persona->nombre }} {{ $fideicomitente->persona->ap_paterno }} {{ $fideicomitente->persona->ap_materno }} {{ $fideicomitente->persona->razon_social }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Fideicomisarios ({{ $predio->fideicomisarios()->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Tipo de persona</th>
                    <th class="px-2">Nombre / Razón social</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->fideicomisarios()->sortBy('persona.nombre') as $fideicomisario)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $fideicomisario->persona->tipo }}</td>
                        <td class=" px-2 w-full ">{{ $fideicomisario->persona->nombre }} {{ $fideicomisario->persona->ap_paterno }} {{ $fideicomisario->persona->ap_materno }} {{ $fideicomisario->persona->razon_social }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Fiduciarias ({{ $predio->fiduciarias()->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Tipo de persona</th>
                    <th class="px-2">Nombre / Razón social</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->fiduciarias()->sortBy('persona.nombre') as $fiduciaria)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $fiduciaria->persona->tipo }}</td>
                        <td class=" px-2 w-full ">{{ $fiduciaria->persona->nombre }} {{ $fiduciaria->persona->ap_paterno }} {{ $fiduciaria->persona->ap_materno }} {{ $fiduciaria->persona->razon_social }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Auditoria ({{ $aviso->audits->count()}})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Usuario</th>
                    <th class="px-2">Movimiento</th>
                    <th class="px-2">Fecha</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($aviso->audits as $audit)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full">{{ $audit->user?->name }}</td>
                        <td class=" px-2 w-full">{{ Str::ucfirst($audit->event) }}: {{ $audit->tags }}</td>
                        <td class=" px-2 w-full">{{ $audit->created_at }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <x-dialog-modal wire:model="modal" >

        <x-slot name="title">
            Trámite
        </x-slot>

        <x-slot name="content">

            @if($data_tramite_aviso)

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Folio:</strong> {{ $data_tramite_aviso['año'] }}-{{ $data_tramite_aviso['folio'] }}-{{ $data_tramite_aviso['usuario'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Estado:</strong> {{ Str::ucfirst($data_tramite_aviso['estado']) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Servicio:</strong> {{ $data_tramite_aviso['servicio'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo de servicio:</strong> {{ Str::ucfirst($data_tramite_aviso['tipo_servicio']) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Solicitante:</strong>{{ $data_tramite_aviso['nombre_solicitante'] }}</p>

                    </div>

                    @if ($data_tramite_aviso['numero_oficio'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Número de oficio:</strong> {{ $data_tramite_aviso['numero_oficio'] }}</p>

                        </div>

                    @endif

                    @if ($data_tramite_aviso['cantidad'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Cantidad:</strong> {{ $data_tramite_aviso['cantidad'] }}</p>

                        </div>

                    @endif

                    @if ($data_tramite_aviso['fecha_vencimiento'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Fecha de vencimiento:</strong> {{ $data_tramite_aviso['fecha_vencimiento'] }}</p>

                        </div>

                    @endif

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Orden de pago:</strong> {{ $data_tramite_aviso['orden_de_pago'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Linea de captura:</strong> {{ $data_tramite_aviso['linea_de_captura'] }}</p>

                    </div>

                    @if ($data_tramite_aviso['folio_pago'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Folio de pago:</strong> {{ $data_tramite_aviso['folio_pago'] }}</p>

                        </div>

                    @endif

                    @if ($data_tramite_aviso['fecha_pago'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Fecha de pago:</strong> {{ $data_tramite_aviso['fecha_pago'] }}</p>

                        </div>

                    @endif

                </div>

                <div class="flex justify-center mt-3">
                    <span class="col-span-1 lg:col-span-2">Cuentas prediales</span>
                </div>

                <div class="rounded-lg bg-gray-100 grid grid-cols-5 gap-2 list-disc p-2">

                    @foreach ($data_tramite_aviso['predios'] as $predio)

                            <span class="">{{ $predio['localidad'] }}-{{ $predio['oficina'] }}-{{ $predio['tipo_predio'] }}-{{ $predio['numero_registro'] }} </span>

                    @endforeach

                </div>

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-red
                    wire:click="$set('modal', false)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal'), false">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
