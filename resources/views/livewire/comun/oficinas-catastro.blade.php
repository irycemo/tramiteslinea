<div x-ref="tramites">

    <div class="mb-6">

        <x-header>Oficinas</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <input wire:model.live.debounce.500mse="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

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

                <x-table.heading>Región</x-table.heading>
                <x-table.heading>Municipio</x-table.heading>
                <x-table.heading>Nombre</x-table.heading>
                <x-table.heading>Oficina</x-table.heading>
                <x-table.heading>Localidad</x-table.heading>
                <x-table.heading>Titular</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($oficinas as $oficina)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $oficina['id'] }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Región</span>

                            {{ $oficina['region'] }}

                        </x-table.cell>


                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Municipio</span>

                            {{ $oficina['municipio'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Nombre</span>

                            {{ $oficina['nombre'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Oficina</span>

                            {{ $oficina['oficina'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Localidad</span>

                            {{ $oficina['localidad'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Titular</span>

                            {{ $oficina['titular'] }}

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
                                        wire:click="abrirModalVerOficina({{ json_encode($oficina) }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver
                                    </button>

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
            Oficina
        </x-slot>

        <x-slot name="content">

            @if($oficinaSeleccionada)

                <div class="space-y-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Región:</strong> {{ $oficinaSeleccionada['region'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Municipio:</strong> {{ $oficinaSeleccionada['municipio'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Oficina:</strong> {{ $oficinaSeleccionada['oficina'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Localidad:</strong> {{ $oficinaSeleccionada['localidad'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo:</strong> {{ $oficinaSeleccionada['tipo'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Nombre:</strong> {{ $oficinaSeleccionada['nombre'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Titular:</strong> {{ $oficinaSeleccionada['titular'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Autoridad municipal:</strong> {{ $oficinaSeleccionada['autoridad_municipal'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Valuador municipal:</strong> {{ $oficinaSeleccionada['valuador_municipal'] }}</p>

                    </div>


                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Teléfonos:</strong> {{ $oficinaSeleccionada['telefonos'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Correo:</strong> {{ $oficinaSeleccionada['email'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Ubicación:</strong> {{ $oficinaSeleccionada['ubicacion'] }}</p>

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
