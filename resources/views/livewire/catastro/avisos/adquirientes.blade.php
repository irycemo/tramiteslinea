<div>

    @if($aviso)

        @include('livewire.catastro.avisos.comun.folio-aviso')

        <div class="">

            <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

                <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Adquirientes</span>

                <div class="flex justify-end mb-2">

                    <div class="flex justify-end mb-2">

                        @if($aviso->tipo == 'revision' && !$aviso->aviso_id)

                            @livewire('comun.propietario-crear', ['sin_transmitentes_flag' => true])

                        @else

                            @livewire('comun.propietario-crear')

                        @endif

                    </div>

                </div>

                <x-table>

                    <x-slot name="head">
                        <x-table.heading >Nombre / Razón social</x-table.heading>
                        <x-table.heading >Porcentaje propiedad</x-table.heading>
                        <x-table.heading >Porcentaje nuda</x-table.heading>
                        <x-table.heading >Porcentaje usufructo</x-table.heading>
                        <x-table.heading ></x-table.heading>
                    </x-slot>

                    <x-slot name="body">

                        @if($aviso->predio)

                            @foreach ($aviso->predio->adquirientes() as $adquiriente)

                                <x-table.row wire:key="row-{{ $adquiriente->id }}">

                                    <x-table.cell>{{ $adquiriente->persona->nombre }} {{ $adquiriente->persona->ap_paterno }} {{ $adquiriente->persona->ap_materno }} {{ $adquiriente->persona->razon_social }}</x-table.cell>
                                    <x-table.cell>{{ $adquiriente->porcentaje_propiedad }}%</x-table.cell>
                                    <x-table.cell>{{ $adquiriente->porcentaje_nuda }}%</x-table.cell>
                                    <x-table.cell>{{ $adquiriente->porcentaje_usufructo }}%</x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center gap-3">
                                            <div>

                                                @if($aviso->tipo == 'revision' && !$aviso->aviso_id)

                                                    <livewire:comun.propietario-actualizar :actor="$adquiriente" :predio="$aviso->predio" :sin_transmitentes_flag="true" wire:key="button-propietario-{{ $adquiriente->id }}" />

                                                @else

                                                    <livewire:comun.propietario-actualizar :actor="$adquiriente" :predio="$aviso->predio" wire:key="button-propietario-{{ $adquiriente->id }}" />

                                                @endif

                                            </div>
                                            <x-button-red
                                                wire:click="borrarActor({{ $adquiriente->id }})"
                                                wire:loading.attr="disabled">
                                                Borrar
                                            </x-button-red>
                                        </div>
                                    </x-table.cell>

                                </x-table.row>

                            @endforeach

                        @endif

                    </x-slot>

                    <x-slot name="tfoot"></x-slot>

                </x-table>

            </div>

        </div>

    @endif

</div>
