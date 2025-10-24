<div>

    @if($aviso)

        @include('livewire.catastro.avisos.comun.folio-aviso')

        <div class="p-4 bg-white shadow-xl rounded-xl mb-5">

            <div class="flex justify-end mb-2">

                @livewire('comun.fideicomiso-crear', ['modelo' => $aviso->predio, 'sub_tipos' => $actores])

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-1 mb-2">

                <div class="mb-3 p-3">

                    <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Fiduciarias ({{ $aviso->predio->fiduciarias()->count() }})</span>

                    @if($aviso->predio->fiduciarias())

                        <x-table>

                            <x-slot name="head">
                                <x-table.heading >Nombre / Razón social</x-table.heading>
                                <x-table.heading ></x-table.heading>
                            </x-slot>

                            <x-slot name="body">

                                @foreach ($aviso->predio->fiduciarias() as $fiduciariaItem)

                                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $fiduciariaItem->id }}">

                                        <x-table.cell>

                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                            <p class="pt-4">{{ $fiduciariaItem->persona->nombre }} {{ $fiduciariaItem->persona->ap_paterno }} {{ $fiduciariaItem->persona->ap_materno }} {{ $fiduciariaItem->persona->razon_social }}</p>

                                        </x-table.cell>
                                        <x-table.cell>
                                            <div class="flex flex-row justify-center items-center gap-3">
                                                <div>

                                                    <livewire:comun.fideicomiso-actualizar :sub_tipos="$actores" :actor="$fiduciariaItem" wire:key="button-fiduciaria-{{ $fiduciariaItem->id }}" size="sm"/>

                                                </div>

                                                <x-button-red
                                                    wire:click="eliminarActor({{ $fiduciariaItem->id }})"
                                                    wire:loading.attr="disabled">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </x-button-red>
                                            </div>
                                        </x-table.cell>

                                    </x-table.row>

                                @endforeach

                            </x-slot>

                            <x-slot name="tfoot"></x-slot>

                        </x-table>

                    @endif

                </div>

                <div class="mb-3 p-3">

                    <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Fideicomitentes ({{ $aviso->predio->fideicomitentes()->count() }})</span>

                    @if($aviso->predio->fideicomitentes())

                        <x-table>

                            <x-slot name="head">
                                <x-table.heading >Nombre / Razón social</x-table.heading>
                                <x-table.heading ></x-table.heading>
                            </x-slot>

                            <x-slot name="body">

                                @foreach ($aviso->predio->fideicomitentes() as $fideicomitenteItem)

                                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $fideicomitenteItem->id }}">

                                        <x-table.cell>

                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                            <p class="pt-4">{{ $fideicomitenteItem->persona->nombre }} {{ $fideicomitenteItem->persona->ap_paterno }} {{ $fideicomitenteItem->persona->ap_materno }} {{ $fideicomitenteItem->persona->razon_social }}</p>

                                        </x-table.cell>
                                        <x-table.cell>
                                            <div class="flex flex-row justify-center items-center gap-3">

                                                <div>

                                                    <livewire:comun.fideicomiso-actualizar :sub_tipos="$actores" :actor="$fideicomitenteItem" wire:key="button-fideicomitente-{{ $fideicomitenteItem->id }}" size="sm"/>

                                                </div>

                                                <x-button-red
                                                    wire:click="eliminarActor({{ $fideicomitenteItem->id }})"
                                                    wire:loading.attr="disabled">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </x-button-red>

                                            </div>
                                        </x-table.cell>

                                    </x-table.row>

                                @endforeach

                            </x-slot>

                            <x-slot name="tfoot"></x-slot>

                        </x-table>

                    @endif

                </div>

                <div class="mb-3 p-3">

                    <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Fideicomisarios ({{ $aviso->predio->fideicomisarios()->count() }})</span>

                    @if($aviso->predio->fideicomisarios())

                        <x-table>

                            <x-slot name="head">
                                <x-table.heading >Nombre / Razón social</x-table.heading>
                                <x-table.heading ></x-table.heading>
                            </x-slot>

                            <x-slot name="body">

                                @foreach ($aviso->predio->fideicomisarios() as $fideicomisarioItem)

                                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $fideicomisarioItem->id }}">

                                        <x-table.cell>

                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                            <p class="pt-4">{{ $fideicomisarioItem->persona->nombre }} {{ $fideicomisarioItem->persona->ap_paterno }} {{ $fideicomisarioItem->persona->ap_materno }} {{ $fideicomisarioItem->persona->razon_social }}</p>

                                        </x-table.cell>
                                        <x-table.cell>
                                            <div class="flex flex-row justify-center items-center gap-3">
                                                <div>

                                                    <livewire:comun.fideicomiso-actualizar :sub_tipos="$actores" :actor="$fideicomisarioItem" wire:key="button-fideicomisario-{{ $fideicomisarioItem->id }}" size="sm"/>

                                                </div>

                                                <x-button-red
                                                    wire:click="eliminarActor({{ $fideicomisarioItem->id }})"
                                                    wire:loading.attr="disabled">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </x-button-red>
                                            </div>
                                        </x-table.cell>

                                    </x-table.row>

                                @endforeach

                            </x-slot>

                            <x-slot name="tfoot"></x-slot>

                        </x-table>

                    @endif

                </div>

            </div>

        </div>

        <div class="p-4 bg-white shadow-xl rounded-xl mb-5">

            <div class="flex gap-3 items-center w-full lg:w-1/2 justify-center mx-auto">

                <x-input-group for="aviso.descripcion_fideicomiso" label="Objeto principal del fideicomiso" :error="$errors->first('aviso.descripcion_fideicomiso')" class="w-full">

                    <textarea rows="3" class="w-full bg-white rounded" wire:model="aviso.descripcion_fideicomiso"></textarea>

                </x-input-group>

            </div>

        </div>

        @include('livewire.catastro.avisos.comun.errores')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end">

            <x-button-green
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar">

                <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

        </div>

    @endif

</div>
