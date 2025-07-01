<div>

    <div class="mb-6">

        <x-header>Entidades</x-header>

        <div class="flex justify-between">

            <div class="flex gap-3">

                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

                <x-input-select class="bg-white rounded-full text-sm w-min" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </x-input-select>

            </div>

            @can('Crear entidad')

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                    <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar nueva entidad

                </button>

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full md:hidden focus:outline-gray-400 focus:outline-offset-2">+</button>

            @endcan

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('dependencia')" :direction="$sort === 'dependencia' ? $direction : null" >Dependencia</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('numero_notaria')" :direction="$sort === 'numero_notaria' ? $direction : null" >Número de notaria</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('email')" :direction="$sort === 'email' ? $direction : null" >Correo</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->entidades as $entidad)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $entidad->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            @if($entidad->estado == 'activo')

                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($entidad->estado) }}</span>

                            @else

                                <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($entidad->estado) }}</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Dependencia</span>

                            {{ $entidad->dependencia ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Número de notaria</span>

                            {{ $entidad->numero_notaria ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Correo</span>

                            {{ $entidad->email }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($entidad->creadoPor != null)Registrado por: {{$entidad->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $entidad->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($entidad->actualizadoPor != null)Actualizado por: {{$entidad->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $entidad->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex justify-center lg:justify-start gap-2">

                                @can('Editar entidad')

                                    <x-button-blue
                                        wire:click="abrirModalEditar({{ $entidad->id }})"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>

                                        <span>Editar</span>

                                    </x-button-blue>

                                @endcan

                                @can('Borrar entidad')

                                    <x-button-red
                                        wire:click="abrirModalBorrar({{ $entidad->id }})"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>

                                        <span>Eliminar</span>

                                    </x-button-red>

                                @endcan

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

                <x-table.row>

                    <x-table.cell colspan="9" class="bg-gray-50">

                        {{ $this->entidades->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal" maxWidth="md">

        <x-slot name="title">

            @if($crear)
                Nueva Entidad
            @elseif($editar)
                Editar Entidad
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="flex flex-col md:flex-row justify-between gap-3 mb-3">

                <x-input-group for="modelo_editar.estado" label="Estado" :error="$errors->first('modelo_editar.estado')">

                    <x-input-select id="modelo_editar.estado" wire:model="modelo_editar.estado">

                        <option value="" selected>Seleccione una opción</option>
                        <option value="activo" selected>Activo</option>
                        <option value="inactivo" selected>Inactivo</option>

                    </x-input-select>

                </x-input-group>

                <x-input-group for="modelo_editar.dependencia" label="Nombre de la dependencia" :error="$errors->first('modelo_editar.dependencia')" class="w-full">

                    <x-input-text id="modelo_editar.dependencia" wire:model="modelo_editar.dependencia" />

                </x-input-group>

            </div>

            <div class="flex flex-col md:flex-row justify-between gap-3 mb-3">

                <x-input-group for="modelo_editar.numero_notaria" label="Número de notaria" :error="$errors->first('modelo_editar.numero_notaria')" class="w-full">

                    <x-input-text type="number" id="modelo_editar.numero_notaria" wire:model="modelo_editar.numero_notaria" />

                </x-input-group>

                <x-input-group for="modelo_editar.email" label="Correo" :error="$errors->first('modelo_editar.email')" class="w-full">

                    <x-input-text type="email" id="modelo_editar.email" wire:model="modelo_editar.email" />

                </x-input-group>

            </div>

            <div class="flex flex-col md:flex-row justify-between gap-3 mb-3">

                <x-input-group for="modelo_editar.notario" label="Notario" :error="$errors->first('modelo_editar.notario')" class="w-full">

                    <x-input-select id="modelo_editar.notario" wire:model="modelo_editar.notario">

                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($notarios as $item)

                            <option value="{{ $item->id }}">{{ $item->name }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

                <x-input-group for="modelo_editar.adscrito" label="Notario adscrito" :error="$errors->first('modelo_editar.adscrito')" class="w-full">

                    <x-input-select id="modelo_editar.adscrito" wire:model="modelo_editar.adscrito">

                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($notarios as $item)

                            <option value="{{ $item->id }}">{{ $item->name }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                @if($crear)

                    <x-button-blue
                        wire:click="guardar"
                        wire:loading.attr="disabled"
                        wire:target="guardar">

                        <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        <span>Guardar</span>
                    </x-button-blue>

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        <span>Actualizar</span>
                    </x-button-blue>

                @endif

                <x-button-red
                    wire:click="resetearTodo"
                    wire:loading.attr="disabled"
                    wire:target="resetearTodo"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar Entidad
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar la entidad? No sera posible recuperar la información.
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
                wire:click="borrar"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
