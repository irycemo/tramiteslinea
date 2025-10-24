<div x-ref="tramites">

    <div class="mb-6">

        <x-header>Certificados</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <select class="bg-white rounded-full text-sm" wire:model.live="año">

                <option value="" selected>Año</option>

                @foreach ($años as $item)

                    <option value="{{ $item }}">{{ $item }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500mse="folio" placeholder="Folio cert." class="bg-white rounded-full text-sm w-24">

            <select class="bg-white rounded-full text-sm" wire:model.live="estado">

                <option value="" selected>Estado</option>
                <option value="activo">Activo</option>
                <option value="cancelado">Cancelado</option>
                <option value="caducado">Caducado</option>

            </select>

            <input type="number" wire:model.live.debounce.500ms="localidad" placeholder="Localidad" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500ms="oficina" placeholder="Oficina" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500ms="tipo_predio" placeholder="T. Predio" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500ms="numero_registro" placeholder="# Registro" class="bg-white rounded-full text-sm w-24">

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

                <x-table.heading>Tipo</x-table.heading>
                <x-table.heading>Año</x-table.heading>
                <x-table.heading>Folio</x-table.heading>
                <x-table.heading>estado</x-table.heading>
                <x-table.heading>Cuenta predial</x-table.heading>
                <x-table.heading>Tramite</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($certificados as $certificado)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $certificado['id'] }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Tipo</span>

                            {{ $certificado['tipo'] }}

                        </x-table.cell>


                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $certificado['año'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $certificado['folio'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Estado</span>

                            @php

                                $color = [
                                    'activo' => 'green-400',
                                    'cancelado' => 'red-400',
                                ][$certificado['estado']] ?? 'gray-400';

                            @endphp

                            <span class="bg-{{ $color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($certificado['estado']) }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                            {{ $certificado['localidad'] }}- {{ $certificado['oficina'] }}- {{ $certificado['tipo_predio'] }}- {{ $certificado['numero_registro'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Servicio</span>

                            {{ $certificado['tramite_año'] }}-{{ $certificado['tramite_folio'] }}-11

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
                                        wire:click="abrirModalVerCertificado({{ json_encode($certificado) }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver
                                    </button>

                                    @if($certificado['estado'] === 'activo')

                                        <button
                                            wire:click="reimprimirCertificado({{ json_encode($certificado) }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Imprimir
                                        </button>

                                        <button
                                            wire:click="abrirModalRequerimiento({{ json_encode($certificado) }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Hacer requerimiento
                                        </button>

                                        @if(count($certificado['requerimientos']))

                                            <button
                                                wire:click="abrirModalVerRequerimientos({{ json_encode($certificado) }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Ver requerimientos
                                            </button>

                                        @endif

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

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">
            Trámite
        </x-slot>

        <x-slot name="content">

            @if($certificadoSeleccionado)

                <div class="space-y-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p>{{ $certificadoSeleccionado['tipo'] }}-{{ $certificadoSeleccionado['año'] }}-{{ $certificadoSeleccionado['folio'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Estado:</strong> {{ Str::ucfirst($certificadoSeleccionado['estado']) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Trámite:</strong> {{ $certificadoSeleccionado['tramite_año'] }}-{{ $certificadoSeleccionado['tramite_folio'] }}-11</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Predio:</strong> {{ $certificadoSeleccionado['localidad'] }}-{{ $certificadoSeleccionado['oficina'] }}-{{ $certificadoSeleccionado['tipo_predio'] }}-{{ $certificadoSeleccionado['numero_registro'] }}</p>

                    </div>

                    @if(isset($certificadoSeleccionado['observaciones']))

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Observaciones:</strong> {{ $certificadoSeleccionado['observaciones'] }}</p>

                        </div>

                    @endif

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

    <x-dialog-modal wire:model="modalRequerimiento" maxWidth="sm">

        <x-slot name="title">
            Hacer Requerimiento
        </x-slot>

        <x-slot name="content">

            <x-input-group for="observacion" label="Observación" :error="$errors->first('observacion')">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observacion" placeholder="Se lo más especifico sobre la corrección que solicitas"></textarea>

            </x-input-group>

            <div class="mt-5">

                <div class="mb-5">

                    <x-filepond wire:model.live="documento" accept="['application/pdf']"/>

                </div>

                <div>

                    @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="hacerRequerimiento"
                    wire:loading.attr="disabled"
                    wire:target="hacerRequerimiento">
                    Solicitar corrección
                </x-button-blue>

                <x-button-red
                    wire:click="$set('modalRequerimiento', false)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modalRequerimiento', false">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modalVerRequerimiento" maxWidth="sm">

        <x-slot name="title">

            Requerimientos

        </x-slot>

        <x-slot name="content">

            @if(isset($certificadoSeleccionado['requerimientos']))

                @forelse ($certificadoSeleccionado['requerimientos'] as $requerimiento)

                    <div class="bg-gray-100 rounded-lg p-2 mb-2">

                        <div>
                            {{ $requerimiento['descripcion'] }}
                        </div>

                        <div class="text-xs text-right">

                            @if(isset($requerimiento['usuario_stl']))

                                <p>{{ $requerimiento['usuario_stl'] }}</p>

                            @else

                                <p>{{ $requerimiento['creado_por'] }}</p>

                            @endif

                            <p>{{ $requerimiento['created_at'] }}</p>

                        </div>

                    </div>

                @empty

                    <div class="bg-gray-100 rounded-lg p-4 text-center">

                        <p>No hay requermientos</p>

                    </div>

                @endforelse

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-red
                    wire:click="$toggle('modalVerRequerimiento')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalVerRequerimiento')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
