<div>

    @if(isset($aviso->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

        </div>

    @endif

    <div class="flex justify-end mb-2">

        @if($aviso->estado === 'nuevo')

            <x-button-gray
                    wire:click="agregarAntecedente"
                    wire:loading.attr="disabled"
                    wire:target="agregarAntecedente">

                    <img wire:loading wire:target="agregarAntecedente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar antecedente
            </x-button-gray>

        @endif

    </div>

    @if($this->aviso->antecedentes->count())

        <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

            <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Antecedentes del inmueble en el Registro Público</span>

            <x-table>

                <x-slot name="head">
                    <x-table.heading >Tomo</x-table.heading>
                    <x-table.heading >Registro</x-table.heading>
                    <x-table.heading >Sección</x-table.heading>
                    <x-table.heading >Distrito</x-table.heading>
                    <x-table.heading >Acto</x-table.heading>
                    <x-table.heading ></x-table.heading>
                </x-slot>

                <x-slot name="body">

                    @if($aviso)

                        @foreach ($aviso->antecedentes as $antecedente)

                            <x-table.row >

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tomo</span>

                                    {{ $antecedente->tomo }}

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registro</span>

                                    {{ $antecedente->registro }}

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Sección</span>

                                    {{ $antecedente->seccion }}

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Distrito</span>

                                    {{ $antecedente->distrito }}

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acto</span>

                                    {{ $antecedente->acto }}

                                </x-table.cell>
                                <x-table.cell>
                                    @if($aviso->estado === 'nuevo')

                                        <div class="flex items-center justify-center gap-3">
                                            <x-button-blue
                                                wire:click="editarAntecedente({{ $antecedente->id }})"
                                                wire:loading.attr="disabled">
                                                Editar
                                            </x-button-blue>
                                            <x-button-red
                                                wire:click="borrarAdquiriente({{ $antecedente->id }})"
                                                wire:loading.attr="disabled">
                                                Borrar
                                            </x-button-red>
                                        </div>

                                    @endif
                                </x-table.cell>

                            </x-table.row>

                        @endforeach

                    @endif

                </x-slot>

                <x-slot name="tfoot"></x-slot>

            </x-table>

        </div>

    @endif

    <x-dialog-modal wire:model="modal" maxWidth="md">

        <x-slot name="title">

            @if($crear)
                Nuevo Antecedente
            @elseif($editar)
                Editar Antecedente
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                <x-input-group for="tomo" label="Tomo" :error="$errors->first('tomo')" class="w-full">

                    <x-input-text type="number" id="tomo" wire:model="tomo" />

                </x-input-group>

                <x-input-group for="registro" label="Registro" :error="$errors->first('registro')" class="w-full">

                    <x-input-text type="number" id="registro" wire:model="registro" />

                </x-input-group>

                <x-input-group for="seccion" label="Sección" :error="$errors->first('seccion')" class="w-full">

                    <x-input-select id="seccion" wire:model="seccion" class="w-full">

                        <option value="">Seleccione una opción</option>

                        @foreach ($secciones as $seccion)

                            <option value="{{ $seccion }}">{{ $seccion }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

                <x-input-group for="distrito" label="Distrito" :error="$errors->first('distrito')" class="w-full">

                    <x-input-select id="distrito" wire:model="distrito" class="w-full">

                        <option value="">Seleccione una opción</option>

                        @foreach ($distritos as $distrito)

                            <option value="{{ $distrito }}">{{ $distrito }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

            </div>

            <x-input-group for="acto" label="Acto" :error="$errors->first('acto')" class="w-full">
                <textarea class="bg-white rounded text-xs w-full " rows="4"  wire:model="acto" ></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                @if($crear)

                    <x-button-blue
                        wire:click="guardarAntecedente"
                        wire:loading.attr="disabled"
                        wire:target="guardarAntecedente">

                        <img wire:loading wire:target="guardarAntecedente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        <span>Guardar</span>
                    </x-button-blue>

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizarAntecedente"
                        wire:loading.attr="disabled"
                        wire:target="actualizarAntecedente">

                        <img wire:loading wire:target="actualizarAntecedente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        <span>Actualizar</span>
                    </x-button-blue>

                @endif

                <x-button-red
                    wire:click="resetear"
                    wire:loading.attr="disabled"
                    wire:target="resetear"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar antecedente
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar el antecedente? No sera posible recuperar la información.
        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="borrarAntecedente"
                wire:loading.attr="disabled"
                wire:target="borrarAntecedente"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
