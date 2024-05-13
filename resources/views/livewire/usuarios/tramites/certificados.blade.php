<div x-ref="tramites">

    <div class="mb-6">

        <x-header>Certificados</x-header>

        <div class="flex justify-between items-center">

            <div class="space-y-2">

                <select class="bg-white rounded-full text-sm" wire:model.live="año">

                    <option value="" selected>Año</option>

                    @foreach ($años as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500mse="folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

                <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading>Estado</x-table.heading>
                <x-table.heading>Año</x-table.heading>
                <x-table.heading>Folio</x-table.heading>
                <x-table.heading>Usuario</x-table.heading>
                <x-table.heading>Servicio</x-table.heading>
                <x-table.heading>Tipo de servicio</x-table.heading>
                <x-table.heading>Fecha de entrega</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($tramites as $tramite)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $tramite['id'] }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            @php

                                $color = [
                                    'nuevo' => 'blue-400',
                                    'pagado' => 'green-400',
                                    'activo' => 'yellow-400',
                                    'concluido' => 'gray-400',
                                    'expirado' => 'red-400',
                                    'inactivo' => 'red-400',
                                    'autorizado' => 'indigo-400',
                                ][$tramite['estado']] ?? 'gray-400';

                            @endphp

                            <span class="bg-{{ $color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($tramite['estado']) }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $tramite['año'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $tramite['folio'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Usuario</span>

                            {{ $tramite['usuario'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Servicio</span>

                            {{ $tramite['servicio'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de servicio</span>

                            {{ Str::ucfirst($tramite['tipo_servicio']) }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de entrega</span>

                            {{ $tramite['fecha_entrega'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            @if(in_array($tramite['estado'], ['pagado', 'autorizado', 'concluido']))

                                <x-button-blue
                                    wire:click="abrirModalVer({{ json_encode($tramite) }})"
                                    wire:loading.attr="disabled">

                                    Ver

                                </x-button-blue>

                            @endif

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="15">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="15" class="bg-gray-50">

                        <div>
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex gap-3 justify-between">
                                <span>
                                    @if ($paginaAnterior)
                                        <button
                                         wire:click="previousPage"
                                         wire:loading.attr="disabled"
                                         rel="prev"
                                         class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                         x-on:click="$refs.tramites.scrollIntoView()">

                                            <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                            </svg>
                                          Anterior

                                        </button>
                                    @endif
                                </span>

                                <span>
                                    @if ($paginaSiguiente)
                                        <button
                                        wire:click="nextPage"
                                        wire:loading.attr="disabled"
                                        rel="next"
                                        class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        x-on:click="$refs.tramites.scrollIntoView()">

                                        Siguiente

                                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                        </svg>

                                    </button>
                                    @endif
                                </span>
                            </nav>
                        </div>

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal" >

        <x-slot name="title">
            Trámite
        </x-slot>

        <x-slot name="content">

            @if($tramiteSeleccionado)

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mb-5">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Folio:</strong> {{ $tramiteSeleccionado['año'] }}-{{ $tramiteSeleccionado['folio'] }}-{{ $tramiteSeleccionado['usuario'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Estado:</strong> {{ Str::ucfirst($tramiteSeleccionado['estado']) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Servicio:</strong> {{ $tramiteSeleccionado['servicio'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo de servicio:</strong> {{ Str::ucfirst($tramiteSeleccionado['tipo_servicio']) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Fecha de entrega:</strong> {{ $tramiteSeleccionado['fecha_entrega'] }}</p>

                    </div>

                </div>

                <div class="rounded-lg bg-gray-100 list-disc p-2">

                    <div class="text-center">

                        <span class="">Cuentas prediales</span>

                    </div>

                    <div class="rounded-lg bg-gray-100 list-disc p-2" wire:loading.class.delaylongest="opacity-50">

                        <div class="text-sm my-3 rounded-lg">

                            <table class="w-full rounded-lg">

                                <thead class="text-left bg-gray-100">

                                    <tr>

                                        <th class="px-2">Localidad</th>
                                        <th class="px-2">Oficina</th>
                                        <th class="px-2">Tipo de predio</th>
                                        <th class="px-2">Número de registro</th>
                                        <th class="px-2"></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($tramiteSeleccionado['predios'] as $item)

                                        <tr class="border-b py-1">

                                            <td class="px-2">
                                                {{ $item['localidad'] }}
                                            </td>
                                            <td class="px-2">
                                                <p>{{ $item['oficina'] }}</p>
                                            </td>
                                            <td class="px-2">
                                                <p>{{ $item['tipo_predio'] }}</p>
                                            </td>
                                            <td class="px-2">
                                                <p>{{ $item['numero_registro'] }}</p>
                                            </td>
                                            <td class="p-2 flex items-center space-x-2">

                                                <x-button-blue
                                                    wire:click="generarCertificado({{ $item['id'] }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="generarCertificado({{ $item['id'] }})">

                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                                    </svg>

                                                </x-button-blue>

                                            </td>

                                        </tr>

                                    @endforeach

                                    <tr>
                                        <td colspan="6">Total: {{ count($tramiteSeleccionado['predios']) }}</td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

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
