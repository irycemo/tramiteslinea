<div>

    @if($aviso)

        @include('livewire.catastro.avisos.comun.folio-aviso')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <div class="flex-auto text-center mb-3">

                <div >

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite del certificado catastral</Label>

                </div>

                <div class="inline-flex">

                    <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año">
                        @foreach ($años as $año)

                            <option value="{{ $año }}">{{ $año }}</option>

                        @endforeach
                    </select>

                    <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio') border-red-500 @enderror" wire:model="folio">

                    <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario') border-red-500 @enderror" wire:model="usuario">

                </div>

            </div>

            @if($aviso->estado == 'nuevo')

                <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                    <button
                        wire:click="buscarCertificado"
                        wire:loading.attr="disabled"
                        wire:target="buscarCertificado"
                        type="button"
                        class="bg-blue-400 mb-3 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                        <img wire:loading wire:target="buscarCertificado" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Consultar certificado

                    </button>

                </div>

            @endif

        </div>

        @if($flag_encadenamiento)

            <div class="mb-2 bg-white rounded-lg p-4 text-center text-sm">

                <p>Avisos relacionados con el el documento de entrada</p>

                @foreach ($avisos_misma_escritura as $aviso_item)

                    {{ $aviso_item->año }}-{{ $aviso_item->folio }}-{{ $aviso_item->usuario }},

                @endforeach

                <x-input-select id="actor" wire:model.live="actor" class="w-min mx-auto">

                    <option value="">Seleccione una opción</option>

                    @foreach ($actores as $actor_item)

                        <option value="{{ $actor_item->id }}">{{ $actor_item->persona->nombre }} {{ $actor_item->persona->ap_paterno }} {{ $actor_item->persona->ap_materno }} {{ $actor_item->persona->razon_social }} / {{ $actor_item->tipo }}</option>

                    @endforeach

                </x-input-select>

            </div>

        @endif

        <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

            <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Transmitentes</span>

            <x-table>

                <x-slot name="head">
                    <x-table.heading >Tipo de persona</x-table.heading>
                    <x-table.heading >Nombre / Razón social</x-table.heading>
                    <x-table.heading >Porcentaje de propiedad</x-table.heading>
                    <x-table.heading >Porcentaje nuda</x-table.heading>
                    <x-table.heading >Porcentaje usufructo</x-table.heading>
                    <x-table.heading ></x-table.heading>
                </x-slot>

                <x-slot name="body">

                    @if($aviso)

                        @foreach ($aviso->predio->transmitentes() as $transmitente)

                            <x-table.row >

                                <x-table.cell title="Tipo de persona">

                                    {{ $transmitente->persona->tipo }}

                                </x-table.cell>

                                <x-table.cell title="Nombre / Razón social">

                                    {{ $transmitente->persona->nombre }} {{ $transmitente->persona->ap_paterno }} {{ $transmitente->persona->ap_materno }} {{ $transmitente->persona->razon_social }}

                                </x-table.cell>

                                <x-table.cell title="% de propiedad">

                                    {{ number_format($transmitente->porcentaje_propiedad, 4) }}%

                                </x-table.cell>

                                <x-table.cell title="% de nuda">

                                    {{ number_format($transmitente->porcentaje_nuda, 4) }}%

                                </x-table.cell>

                                <x-table.cell title=">% de usufructo">

                                    {{ number_format($transmitente->porcentaje_usufructo, 4) }}%

                                </x-table.cell>

                                <x-table.cell tile="Acciones">

                                    @if($aviso->estado == 'nuevo')

                                        <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                            <div>

                                                <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                    </svg>

                                                </button>

                                            </div>

                                            <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                                @if($aviso->estado === 'nuevo')

                                                    <button
                                                        wire:click="borrarTransmitente({{ $transmitente->id }})"
                                                        wire:loading.attr="disabled"
                                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                        role="menuitem">
                                                        Borrar
                                                    </button>

                                                    <button
                                                        wire:click="abrirModalEditar({{ $transmitente->id }})"
                                                        wire:loading.attr="disabled"
                                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                        role="menuitem">
                                                        Editar generales
                                                    </button>

                                                @endif

                                            </div>

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

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">Actualizar generales</x-slot>

        <x-slot name="content">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-3 col-span-2 rounded-lg p-3">

                <x-input-group for="nacionalidad" label="Nacionalidad" :error="$errors->first('nacionalidad')" class="w-full">

                    <x-input-text id="nacionalidad" wire:model="nacionalidad" />

                </x-input-group>

                <x-input-group for="cp" label="Código postal" :error="$errors->first('cp')" class="w-full">

                    <x-input-text type="number" id="cp" wire:model="cp" />

                </x-input-group>

                <x-input-group for="entidad" label="Estado" :error="$errors->first('entidad')" class="w-full">

                    <x-input-text id="entidad" wire:model="entidad" />

                </x-input-group>

                <x-input-group for="municipio" label="Municipio" :error="$errors->first('municipio')" class="w-full">

                    <x-input-text id="municipio" wire:model="municipio" />

                </x-input-group>

                <x-input-group for="ciudad" label="Ciudad" :error="$errors->first('ciudad')" class="w-full">

                    <x-input-text id="ciudad" wire:model="ciudad" />

                </x-input-group>

                <x-input-group for="colonia" label="Colonia" :error="$errors->first('colonia')" class="w-full">

                    <x-input-text id="colonia" wire:model="colonia" />

                </x-input-group>

                <x-input-group for="calle" label="Calle" :error="$errors->first('calle')" class="w-full">

                    <x-input-text id="calle" wire:model="calle" />

                </x-input-group>

                <x-input-group for="numero_exterior" label="Número exterior" :error="$errors->first('numero_exterior')" class="w-full">

                    <x-input-text id="numero_exterior" wire:model="numero_exterior" />

                </x-input-group>

                <x-input-group for="numero_interior" label="Número interior" :error="$errors->first('numero_interior')" class="w-full">

                    <x-input-text id="numero_interior" wire:model="numero_interior" />

                </x-input-group>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3 justify-end">

                <x-button-green
                    wire:click="actualizarTransmitente"
                    wire:loading.attr="disabled"
                    wire:target="actualizarTransmitente">

                    <img wire:loading wire:target="actualizarTransmitente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Actualizar</span>
                </x-button-green>

                <x-button-red
                    wire:click="$toggle('modal')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
