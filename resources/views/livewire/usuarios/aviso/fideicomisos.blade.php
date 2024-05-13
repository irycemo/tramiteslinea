<div>

    @if(isset($aviso->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

        </div>

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <x-input-group for="aviso.descripcion_fideicomiso" label="Objeto principal del fideicomiso" :error="$errors->first('aviso.descripcion_fideicomiso')" class="w-full lg:w-1/2 mx-auto">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="aviso.descripcion_fideicomiso"></textarea>

            </x-input-group>

            <div class="flex justify-center">

                @if($aviso->estado === 'nuevo')

                    <x-button-gray
                            wire:click="agregarDescripcion"
                            wire:loading.attr="disabled"
                            wire:target="agregarDescripcion">

                            <img wire:loading wire:target="agregarDescripcion" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            Guardar
                    </x-button-gray>

                @endif

            </div>

        </div>

    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-1 mb-2">

        <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

            <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Fiduciaria ({{ $aviso->fiduciaria()->count() }})</span>

            <div class="flex justify-end mb-2">

                @if($aviso->estado === 'nuevo')

                    <x-button-gray
                            wire:click="agregarFiduciaria"
                            wire:loading.attr="disabled"
                            wire:target="agregarFiduciaria">

                            <img wire:loading wire:target="agregarFiduciaria" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            Agregar fiduciaria
                    </x-button-gray>

                @endif

            </div>

            <x-table>

                <x-slot name="head">
                    <x-table.heading >Nombre / Razón social</x-table.heading>
                    <x-table.heading ></x-table.heading>
                </x-slot>

                <x-slot name="body">

                    @foreach ($aviso->fiduciaria() as $fiduciariaItem)

                        <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $fiduciariaItem->id }}">

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                <p class="pt-4">{{ $fiduciariaItem->persona->nombre }} {{ $fiduciariaItem->persona->ap_paterno }} {{ $fiduciariaItem->persona->ap_materno }} {{ $fiduciariaItem->persona->razon_social }}</p>

                            </x-table.cell>
                            <x-table.cell>
                                @if($aviso->estado === 'nuevo')

                                    <div class="flex flex-row justify-center items-center gap-3">
                                        <x-button-blue
                                            wire:click="editarActor({{ $fiduciariaItem->id }}"
                                            wire:loading.attr="disabled"
                                        >

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>

                                        </x-button-blue>
                                        <x-button-red
                                            wire:click="borrarActor({{ $fiduciariaItem->id }})"
                                            wire:loading.attr="disabled">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>

                                        </x-button-red>
                                    </div>

                                @endif
                            </x-table.cell>

                        </x-table.row>

                    @endforeach

                </x-slot>

                <x-slot name="tfoot"></x-slot>

            </x-table>

        </div>

        <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

            <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Fideicomitentes ({{ $aviso->fideicomitentes()->count() }})</span>

            <div class="flex justify-end mb-2">

                @if($aviso->estado === 'nuevo')

                    <x-button-gray
                            wire:click="agregarFideicomitente"
                            wire:loading.attr="disabled"
                            wire:target="agregarFideicomitente">

                            <img wire:loading wire:target="agregarFideicomitente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            Agregar fideicomitente
                    </x-button-gray>

                @endif

            </div>

            <x-table>

                <x-slot name="head">
                    <x-table.heading >Nombre / Razón social</x-table.heading>
                    <x-table.heading ></x-table.heading>
                </x-slot>

                <x-slot name="body">

                    @foreach ($aviso->fideicomitentes() as $fideicomitenteItem)

                        <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $fideicomitenteItem->id }}">

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                <p class="pt-4">{{ $fideicomitenteItem->persona->nombre }} {{ $fideicomitenteItem->persona->ap_paterno }} {{ $fideicomitenteItem->persona->ap_materno }} {{ $fideicomitenteItem->persona->razon_social }}</p>

                            </x-table.cell>
                            <x-table.cell>
                                @if($aviso->estado === 'nuevo')

                                    <div class="flex flex-row justify-center items-center gap-3">
                                        <x-button-blue
                                            wire:click="editarActor({{ $fideicomitenteItem->id }})"
                                            wire:traget="editarActor({{ $fideicomitenteItem->id }})"
                                            wire:loading.attr="disabled"
                                        >

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>

                                        </x-button-blue>
                                        <x-button-red
                                            wire:click="borrarActor({{ $fideicomitenteItem->id }})"
                                            wire:loading.attr="disabled">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>

                                        </x-button-red>
                                    </div>

                                @endif
                            </x-table.cell>

                        </x-table.row>

                    @endforeach

                </x-slot>

                <x-slot name="tfoot"></x-slot>

            </x-table>

        </div>

        <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

            <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Fideicomisarios ({{ $aviso->fideicomisarios()->count() }})</span>

            <div class="flex justify-end mb-2">

                @if($aviso->estado === 'nuevo')

                    <x-button-gray
                            wire:click="agregarFideicomisario"
                            wire:loading.attr="disabled"
                            wire:target="agregarFideicomisario">

                            <img wire:loading wire:target="agregarFideicomisario" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            Agregar fideicomisario
                    </x-button-gray>

                @endif

            </div>

            <x-table>

                <x-slot name="head">
                    <x-table.heading >Nombre / Razón social</x-table.heading>
                    <x-table.heading ></x-table.heading>
                </x-slot>

                <x-slot name="body">

                    @foreach ($aviso->fideicomisarios() as $fideicomisarioItem)

                        <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $fideicomisarioItem->id }}">

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                <p class="pt-4">{{ $fideicomisarioItem->persona->nombre }} {{ $fideicomisarioItem->persona->ap_paterno }} {{ $fideicomisarioItem->persona->ap_materno }} {{ $fideicomisarioItem->persona->razon_social }}</p>

                            </x-table.cell>
                            <x-table.cell>
                                @if($aviso->estado === 'nuevo')

                                    <div class="flex flex-row justify-center items-center gap-3">
                                        <x-button-blue
                                            wire:click="editarActor({{ $fideicomisarioItem->id }})"
                                            wire:loading.attr="disabled"
                                        >

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>

                                        </x-button-blue>
                                        <x-button-red
                                            wire:click="borrarActor({{ $fideicomisarioItem->id }})"
                                            wire:loading.attr="disabled">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>

                                        </x-button-red>
                                    </div>

                                @endif
                            </x-table.cell>

                        </x-table.row>

                    @endforeach

                </x-slot>

                <x-slot name="tfoot"></x-slot>

            </x-table>

        </div>

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            @if($crear)
                @if($fideicomitente === true)
                    Nuevo Fideicomitente
                @elseif($fideicomisario  === true)
                    Nuevo Fideicomisario
                @elseif($fiduciaria  === true)
                    Nueva fiduciaria
                @endif
            @elseif($editar)
                @if($fideicomitente)
                    Editar Fideicomitente
                @elseif($fideicomisario)
                    Editar Fideicomisario
                @elseif($fiduciaria)
                    Editar fiduciaria
                @endif
            @endif

        </x-slot>

        <x-slot name="content">

            {{ $errors }}

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-3 col-span-2 rounded-lg p-3">

                <x-input-group for="tipo_persona" label="Tipo de persona" :error="$errors->first('tipo_persona')" class="w-full">

                    <x-input-select id="tipo_persona" wire:model.live="tipo_persona" class="w-full">

                        <option value="">Seleccione una opción</option>
                        <option value="MORAL">MORAL</option>
                        <option value="FISICA">FISICA</option>

                    </x-input-select>

                </x-input-group>

                @if($tipo_persona == 'FISICA')

                    <x-input-group for="nombre" label="Nombre(s)" :error="$errors->first('nombre')" class="w-full">

                        <x-input-text id="nombre" wire:model="nombre" />

                    </x-input-group>

                    <x-input-group for="ap_paterno" label="Apellido paterno" :error="$errors->first('ap_paterno')" class="w-full">

                        <x-input-text id="ap_paterno" wire:model="ap_paterno" />

                    </x-input-group>

                    <x-input-group for="ap_materno" label="Apellido materno" :error="$errors->first('ap_materno')" class="w-full">

                        <x-input-text id="ap_materno" wire:model="ap_materno" />

                    </x-input-group>

                    <x-input-group for="curp" label="CURP" :error="$errors->first('curp')" class="w-full">

                        <x-input-text id="curp" wire:model="curp" />

                    </x-input-group>

                    <x-input-group for="fecha_nacimiento" label="Fecha de nacimiento" :error="$errors->first('fecha_nacimiento')" class="w-full">

                        <x-input-text type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento" />

                    </x-input-group>

                    <x-input-group for="estado_civil" label="Estado civil" :error="$errors->first('estado_civil')" class="w-full">

                        <x-input-select id="estado_civil" wire:model="estado_civil" class="w-full">

                            <option value="">Seleccione una opción</option>

                            @foreach ($estados_civiles as $estado)

                                <option value="{{ $estado }}">{{ $estado }}</option>

                            @endforeach

                        </x-input-select>

                    </x-input-group>

                @elseif($tipo_persona == 'MORAL')

                    <x-input-group for="razon_social" label="Razon social" :error="$errors->first('razon_social')" class="w-full">

                        <x-input-text id="razon_social" wire:model="razon_social" />

                    </x-input-group>

                @endif

                <x-input-group for="rfc" label="RFC" :error="$errors->first('rfc')" class="w-full">

                    <x-input-text id="rfc" wire:model="rfc" />

                </x-input-group>

                <x-input-group for="nacionalidad" label="Nacionalidad" :error="$errors->first('nacionalidad')" class="w-full">

                    <x-input-text id="nacionalidad" wire:model="nacionalidad" />

                </x-input-group>

                <span class="flex items-center justify-center text-lg text-gray-700 md:col-span-3 col-span-1 sm:col-span-2">Domicilio</span>

                <x-input-group for="cp" label="Código postal" :error="$errors->first('cp')" class="w-full">

                    <x-input-text type="number" id="cp" wire:model="cp" />

                </x-input-group>

                <x-input-group for="entidad" label="Entidad" :error="$errors->first('entidad')" class="w-full">

                    <x-input-select id="entidad" wire:model="entidad" class="w-full">

                        <option value="">Seleccione una opción</option>

                        @foreach ($estados as $item)

                            <option value="{{  $item }}">{{  $item }}</option>

                        @endforeach

                    </x-input-select>

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

            <div class="flex gap-3">

                @if($crear)

                    @if($fideicomitente)

                        <x-button-blue
                            wire:click="guardarActor('fideicomitente')"
                            wire:loading.attr="disabled"
                            wire:target="guardarActor('fideicomitente')">

                            <img wire:loading wire:target="guardarActor('fideicomitente')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            <span>Guardar</span>
                        </x-button-blue>

                    @elseif($fideicomisario)

                        <x-button-blue
                            wire:click="guardarActor('fideicomisario')"
                            wire:loading.attr="disabled"
                            wire:target="guardarActor('fideicomisario')">

                            <img wire:loading wire:target="guardarActor('fideicomisario')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            <span>Guardar</span>
                        </x-button-blue>

                    @elseif($fiduciaria)

                        <x-button-blue
                            wire:click="guardarActor('fiduciaria')"
                            wire:loading.attr="disabled"
                            wire:target="guardarActor('fiduciaria')">

                            <img wire:loading wire:target="guardarActor('fiduciaria')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            <span>Guardar</span>
                        </x-button-blue>

                    @endif

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizarActor"
                        wire:loading.attr="disabled"
                        wire:target="actualizarActor">

                        <img wire:loading wire:target="actualizarActor" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

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

</div>
