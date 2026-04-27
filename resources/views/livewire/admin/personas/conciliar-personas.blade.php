<div>

    <x-header>Conciliar personas</x-header>

    <div class="bg-white p-4 rounded-lg mb-5 shadow-xl">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-3 col-span-2 rounded-lg w-full lg:w-1/2 mx-auto">

            <x-input-group for="nombre" label="Nombre(s)" :error="$errors->first('nombre')" class="w-full">

                <x-input-text id="nombre" wire:model="nombre"/>

            </x-input-group>

            <x-input-group for="ap_paterno" label="Apellido paterno" :error="$errors->first('ap_paterno')" class="w-full">

                <x-input-text id="ap_paterno" wire:model="ap_paterno"/>

            </x-input-group>

            <x-input-group for="ap_materno" label="Apellido materno" :error="$errors->first('ap_materno')" class="w-full">

                <x-input-text id="ap_materno" wire:model="ap_materno"/>

            </x-input-group>

            <x-input-group for="razon_social" label="Razon social" :error="$errors->first('razon_social')" class="w-full col-span-1 sm:col-span-2 md:col-span-3">

                <x-input-text id="razon_social" wire:model="razon_social" />

            </x-input-group>

        </div>

        <div class="felx justify-center">

            <x-button-blue
                wire:click="buscar"
                wire:target="buscar"
                wire:loading.attr="disabled"
                class="mx-auto">

                <img wire:loading wire:target="buscar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Buscar persona

            </x-button-blue>

        </div>

    </div>

    @if(count($personas))

        <div class="bg-white p-4 rounded-lg mb-5 shadow-xl flex justify-between">

            <span>Se encontraron:  {{ count($personas) }} personas</span>

            <x-button-blue
                wire:click="$toggle('modal')"
                wire:target="$toggle('modal')"
                wire:loading.attr="disabled"
                >

                <img wire:loading wire:target="$toggle('modal')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Conciliar

            </x-button-blue>

        </div>

    @endif

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading >Nombre</x-table.heading>
                <x-table.heading >Ap paterno</x-table.heading>
                <x-table.heading >Ap materno</x-table.heading>
                <x-table.heading >Razón social</x-table.heading>
                <x-table.heading >RFC</x-table.heading>
                <x-table.heading >CURP</x-table.heading>
                <x-table.heading >Registro</x-table.heading>
                <x-table.heading >Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($personas as $key => $persona)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{$persona->id }}">

                        <x-table.cell title="Nombre">

                            {{$persona->nombre ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="Ap paterno">

                            {{$persona->ap_paterno ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="Ap materno">

                            {{$persona->ap_materno ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="Razón social">

                            {{$persona->razon_social ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="RFC">

                            {{$persona->rfc ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="CURP">

                            {{$persona->curp ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            <span class="font-semibold">@if($persona->creadoPor != null)Registrado por: {{$persona->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{$persona->created_at }}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            <span class="font-semibold">@if($persona->actualizadoPor != null)Actualizado por: {{$persona->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{$persona->updated_at }}

                        </x-table.cell>

                        <x-table.cell title="Acciones">

                            <div class="flex justify-center lg:justify-start gap-2">

                                <x-button-red
                                    wire:click="quitarPersona({{$key }})"
                                    wire:loading.attr="disabled"
                                >

                                    <span>Quitar</span>

                                </x-button-red>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="9">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">
            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">Conciliar persona</x-slot>

        <x-slot name="content">

            <div class="mb-3 rounded-lg p-3">

                <x-input-group for="tipo" label="Tipo de persona" :error="$errors->first('tipo')" class="w-full">

                    <x-input-select id="tipo" wire:model.live="tipo" class="w-full">

                        <option value="">Seleccione una opción</option>
                        <option value="MORAL">MORAL</option>
                        <option value="FÍSICA">FISICA</option>

                    </x-input-select>

                </x-input-group>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-3 col-span-2 rounded-lg p-3">

                <x-input-group for="nombre" label="Nombre(s)" :error="$errors->first('nombre')" class="w-full">

                    <x-input-text id="nombre" wire:model="nombre"  />

                </x-input-group>

                <x-input-group for="ap_paterno" label="Apellido paterno" :error="$errors->first('ap_paterno')" class="w-full">

                    <x-input-text id="ap_paterno" wire:model="ap_paterno"  />

                </x-input-group>

                <x-input-group for="ap_materno" label="Apellido materno" :error="$errors->first('ap_materno')" class="w-full">

                    <x-input-text id="ap_materno" wire:model="ap_materno"  />

                </x-input-group>

            </div>

            <div class="mb-3 p-3">

                <x-input-group for="razon_social" label="Razon social" :error="$errors->first('razon_social')" class="w-full">

                    <x-input-text id="razon_social" wire:model="razon_social"  />

                </x-input-group>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-3 col-span-2 rounded-lg p-3">

                <div class=" col-span-3 rounded-lg">

                    <x-input-group for="multiple_nombre" label="Nombre multiple (Opcional)" :error="$errors->first('multiple_nombre')" class="sm:col-span-2 lg:col-span-3">

                        <textarea rows="3" class="w-full bg-white rounded text-sm" wire:model="multiple_nombre"></textarea>

                    </x-input-group>

                </div>

                <x-input-group for="curp" label="CURP" :error="$errors->first('curp')" class="w-full">

                    <x-input-text id="curp" wire:model="curp"  />

                </x-input-group>

                <x-input-group for="fecha_nacimiento" label="Fecha de nacimiento" :error="$errors->first('fecha_nacimiento')" class="w-full">

                    <x-input-text type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento" />

                </x-input-group>

                <x-input-group for="estado_civil" label="Estado civil" :error="$errors->first('estado_civil')" class="w-full">

                    <x-input-text id="estado_civil" wire:model="estado_civil" />

                </x-input-group>

                <x-input-group for="rfc" label="RFC" :error="$errors->first('rfc')" class="w-full">

                    <x-input-text id="rfc" wire:model="rfc"  />

                </x-input-group>

                <x-input-group for="nacionalidad" label="Nacionalidad" :error="$errors->first('nacionalidad')" class="w-full">

                    <x-input-text id="nacionalidad" wire:model="nacionalidad" />

                </x-input-group>

                <span class="flex items-center justify-center text-lg text-gray-700 md:col-span-3 col-span-1 sm:col-span-2">Domicilio</span>

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

            <div class="flex justify-end gap-4">

                <x-button-blue
                    wire:click="conciliar"
                    wire:loading.attr="disabled"
                    wire:target="conciliar"
                    wire:confirm="¿Esta seguro que desea conciliar a todas las personas que aparecen en la lista?">

                    <img wire:loading wire:target="conciliar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Conciliar</span>

                </x-button-blue>

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
