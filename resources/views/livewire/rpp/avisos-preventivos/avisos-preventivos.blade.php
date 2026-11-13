<div x-ref="tramites">

    <div class="mb-2 lg:mb-5">

        <x-header>Avisos preventivos</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <select class="bg-white rounded-full text-sm" wire:model.live="estado">

                <option value="" selected>Estado</option>
                <option value="nuevo">Nuevo</option>
                <option value="elaborado,finalizado,concluido">Elaborado</option>
                <option value="rechazado">Rechazado</option>

            </select>

            <input type="number" wire:model.live.debounce.500mse="filters.folio_real" placeholder="Folio real" class="bg-white rounded-full text-sm w-24">

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.tramite_año">

                <option value="" selected>Año</option>

                @foreach ($años as $item)

                    <option value="{{ $item }}">{{ $item }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500mse="filters.tramite_folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500mse="filters.tramite_usuario" placeholder="Usuario" class="bg-white rounded-full text-sm w-24">

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
                <x-table.heading>Folio real</x-table.heading>
                <x-table.heading>Tramite</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->avisos as $aviso)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $aviso['id'] }}">

                        <x-table.cell title="Estado">

                            @if(in_array($aviso['estado'], ['elaborado', 'finalizado', 'concluido']))

                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">Elaborado</span>

                            @else

                                <span class="bg-blue-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($aviso['estado']) }}</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell title="Folio real">

                            {{ $aviso['folio_real'] ?? 'Pendiente' }}

                        </x-table.cell>

                        <x-table.cell title="Trámite">

                            {{ $aviso->tramiteFolio() }}

                        </x-table.cell>

                        <x-table.cell  title="Acciones">

                            <div class="relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 top-0 absolute mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    <button
                                        wire:click="abrirModalEditar({{ $aviso->id }})"
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

                        {{ $this->avisos->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">
            Aviso preventivo
        </x-slot>

        <x-slot name="content">

            @if($modelo_editar)

                <div class="space-y-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Trámite:</strong> {{ $aviso->tramiteFolio() }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Folio real:</strong> {{ $aviso->folio_real }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Estado:</strong> {{ $aviso->estado }}</p>

                    </div>

                </div>

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                @if($modelo_editar->estado == 'elaborado')

                    <x-button-blue
                        wire:click="imprimirCaratula"
                        wire:loading.attr="disabled"
                        wire:target="imprimirCaratula">

                        <img wire:loading wire:target="imprimirCaratula" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Imprimir caratula
                    </x-button-blue>

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
