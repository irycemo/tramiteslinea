<div>

    @if(isset($aviso->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

        </div>

    @endif

    <div class="flex justify-end mb-2">

        @if($aviso->estado === 'nuevo')

            <x-button-gray
                    wire:click="agregarAdquiriente"
                    wire:loading.attr="disabled"
                    wire:target="agregarAdquiriente">

                    <img wire:loading wire:target="agregarAdquiriente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar adquiriente
            </x-button-gray>

        @endif

    </div>

    @if($this->aviso->adquirientes()->count())

        <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

            <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Adquirientes</span>

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

                        @foreach ($aviso->adquirientes() as $adquiriente)

                            <x-table.row >

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de persona</span>

                                    {{ $adquiriente->persona->tipo }}

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                    <p class="pt-4">{{ $adquiriente->persona->nombre }} {{ $adquiriente->persona->ap_paterno }} {{ $adquiriente->persona->ap_materno }} {{ $adquiriente->persona->razon_social }}</p>

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">% de propiedad</span>

                                    {{ number_format($adquiriente->porcentaje, 2) }}%

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">% de nuda</span>

                                    {{ number_format($adquiriente->porcentaje_nuda, 2) }}%

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">% de usufructo</span>

                                    {{ number_format($adquiriente->porcentaje_usufructo, 2) }}%

                                </x-table.cell>
                                <x-table.cell>
                                    @if($aviso->estado === 'nuevo')

                                        <div class="flex items-center justify-center gap-3">
                                            <x-button-blue
                                                wire:click="editarAdquiriente({{ $adquiriente->id }})"
                                                wire:loading.attr="disabled">
                                                Editar
                                            </x-button-blue>
                                            <x-button-red
                                                wire:click="borrarAdquiriente({{ $adquiriente->id }})"
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

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            @if($crear)
                Nuevo Adquiriente
            @elseif($editar)
                Editar Adquiriente
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

                <x-input-group for="municipio_propietario" label="Municipio" :error="$errors->first('municipio_propietario')" class="w-full">

                    <x-input-text id="municipio_propietario" wire:model="municipio_propietario" />

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

                <x-input-group for="numero_exterior_propietario" label="Número exterior" :error="$errors->first('numero_exterior_propietario')" class="w-full">

                    <x-input-text id="numero_exterior_propietario" wire:model="numero_exterior_propietario" />

                </x-input-group>

                <x-input-group for="numero_interior_propietario" label="Número interior" :error="$errors->first('numero_interior_propietario')" class="w-full">

                    <x-input-text id="numero_interior_propietario" wire:model="numero_interior_propietario" />

                </x-input-group>

                <x-input-group for="correo" label="Email" :error="$errors->first('correo')" class="w-full">

                    <x-input-text type="email" id="correo" wire:model="correo" />

                </x-input-group>

                <span class="flex items-center justify-center text-lg text-gray-700 md:col-span-3 col-span-1 sm:col-span-2">Porcentajes</span>

                <x-input-group for="porcentaje" label="Porcentaje de propiedad" :error="$errors->first('porcentaje')" class="w-full">

                    <x-input-text min="1" type="number" id="porcentaje" wire:model.lazy="porcentaje" />

                </x-input-group>

                <x-input-group for="porcentaje_nuda" label="Porcentaje nuda" :error="$errors->first('porcentaje_nuda')" class="w-full">

                    <x-input-text min="1" type="number" id="porcentaje_nuda" wire:model.lazy="porcentaje_nuda" />

                </x-input-group>

                <x-input-group for="porcentaje_usufructo" label="Porcentaje usufructo" :error="$errors->first('porcentaje_usufructo')" class="w-full">

                    <x-input-text min="1" type="number" id="porcentaje_usufructo" wire:model.lazy="porcentaje_usufructo" />

                </x-input-group>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                @if($crear)

                    <x-button-blue
                        wire:click="guardarAdquiriente"
                        wire:loading.attr="disabled"
                        wire:target="guardarAdquiriente">

                        <img wire:loading wire:target="guardarAdquiriente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        <span>Guardar</span>
                    </x-button-blue>

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

    <x-confirmation-modal wire:model="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar adquiriente
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar el adquiriente? No sera posible recuperar la información.
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
                wire:click="borrarAdquiriente"
                wire:loading.attr="disabled"
                wire:target="borrarAdquiriente"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
