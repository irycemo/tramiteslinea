<div x-ref="tramites">

    <div class="mb-6">

        <x-header>Trámites</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <select class="bg-white rounded-full text-sm" wire:model.live="año">

                @foreach ($años as $item)

                    <option value="{{ $item }}">{{ $item }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500mse="folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

            <select class="bg-white rounded-full text-sm" wire:model.live="estado">

                <option value="" selected>Estado</option>
                <option value="nuevo">Nuevo</option>
                <option value="pagado">Pagado</option>
                <option value="concluido">Concluido</option>
                <option value="expirado">Expirado</option>

            </select>

            <select class="bg-white rounded-full text-sm w-60" wire:model.live="servicio">

                <option value="" selected>Servicio</option>

                @foreach ($servicios as $servicio)

                    <option value="{{ $servicio['id'] }}" class="truncate">{{ $servicio['nombre'] }}</option>

                @endforeach

            </select>

            <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>

            </select>

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
                <x-table.heading>Cantidad</x-table.heading>
                <x-table.heading>Monto</x-table.heading>
                <x-table.heading>Tipo de servicio</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($tramites as $tramite)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $tramite['id'] }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Estado</span>

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

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $tramite['año'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $tramite['folio'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Usuario</span>

                            {{ $tramite['usuario'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Servicio</span>

                            <p class="mt-3">{{ $tramite['servicio'] }}</p>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Cantidad</span>

                            {{ $tramite['cantidad'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Monto</span>

                            ${{ number_format($tramite['monto'], 2) }}

                        </x-table.cell>

                        <x-table.cell class="capitalize">

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Tipo de servicio</span>

                            {{ $tramite['tipo_servicio'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    <button
                                        wire:click="abrirModalVer({{ json_encode($tramite) }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver trámite
                                    </button>

                                    @if($tramite['estado'] == 'nuevo')

                                        <button
                                            wire:click="genererOrdenPago({{ json_encode($tramite) }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Imprimir orden de pago
                                        </button>

                                    @endif

                                </div>

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

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

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

                        <p><strong>Solicitante:</strong>{{ $tramiteSeleccionado['nombre_solicitante'] }}</p>

                    </div>

                    @if ($tramiteSeleccionado['numero_oficio'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Número de oficio:</strong> {{ $tramiteSeleccionado['numero_oficio'] }}</p>

                        </div>

                    @endif

                    @if ($tramiteSeleccionado['cantidad'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Cantidad:</strong> {{ $tramiteSeleccionado['cantidad'] }}</p>

                        </div>

                    @endif

                    @if ($tramiteSeleccionado['fecha_vencimiento'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Fecha de vencimiento:</strong> {{ $tramiteSeleccionado['fecha_vencimiento'] }}</p>

                        </div>

                    @endif

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Orden de pago:</strong> {{ $tramiteSeleccionado['orden_de_pago'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Linea de captura:</strong> {{ $tramiteSeleccionado['linea_de_captura'] }}</p>

                    </div>

                    @if ($tramiteSeleccionado['folio_pago'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Folio de pago:</strong> {{ $tramiteSeleccionado['folio_pago'] }}</p>

                        </div>

                    @endif

                    @if ($tramiteSeleccionado['fecha_pago'])

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Fecha de pago:</strong> {{ $tramiteSeleccionado['fecha_pago'] }}</p>

                        </div>

                    @endif

                </div>

                <div class="flex justify-center mt-3">
                    <span class="col-span-1 lg:col-span-2">Cuentas prediales</span>
                </div>

                <div class="rounded-lg bg-gray-100 flex gap-4 py-1 px-2">

                    @foreach ($tramiteSeleccionado['predios'] as $predio)

                            <span class="whitespace-nowrap">{{ $predio['localidad'] }}-{{ $predio['oficina'] }}-{{ $predio['tipo_predio'] }}-{{ $predio['numero_registro'] }} </span>

                    @endforeach

                </div>

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                @if(isset($tramiteSeleccionado) && $tramiteSeleccionado['estado'] === 'nuevo')

                    <form action="{{ $link_pago_linea }}" method="post" class="w-full">

                        <input type="hidden" name="concepto" value="{{ config('services.sap.secret_iv') }}">
                        <input type="hidden" name="lcaptura" value="{{ $tramiteSeleccionado['linea_de_captura'] }}">
                        <input type="hidden" name="monto" value="{{ $tramiteSeleccionado['monto'] }}">
                        <input type="hidden" name="urlRetorno" value="{{ route('acredita_pago') }}">
                        <input type="hidden" name="fecha_vencimiento" value="{{ $tramiteSeleccionado['fecha_vencimiento'] }}">
                        <input type="hidden" name="tkn" value="{{ $token }}">

                        <x-button-blue
                            wire:loading.attr="disabled"
                            type="submit">

                            <img wire:loading wire:target="pagarEnLinea" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            <p>Pagar en linea</p>

                        </x-button-blue>

                    </form>

                @endif

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
