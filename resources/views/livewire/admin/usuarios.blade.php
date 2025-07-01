<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Usuarios</h1>

        <div class="flex justify-between items-center ">

            <div class="space-y-2">

                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm ">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.rol">

                    <option value="">Seleccione un rol</option>

                    @foreach ($roles as $rolitem)

                        <option value="{{ $rolitem->name }}">{{ $rolitem->name }}</option>

                    @endforeach

                </select>

                <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

            @can('Crear usuario')

                <div class="">

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                        <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        Agregar nuevo usuario

                    </button>

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full md:hidden focus:outline-gray-400 focus:outline-offset-2">+</button>

                </div>

            @endcan

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('name')" :direction="$sort === 'name' ? $direction : null" >Nombre</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('clave')" :direction="$sort === 'clave' ? $direction : null" >Clave</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('email')" :direction="$sort === 'email' ? $direction : null" >Correo</x-table.heading>
                <x-table.heading >Rol</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->usuarios as $usuario)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $usuario->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre</span>

                            <div class="flex items-center justify-center lg:justify-start">

                                <img class="h-10 w-10 rounded-full" src="{{ $usuario->profile_photo_url }}" alt="{{ $usuario->name }}">

                                <span class="text-sm text-gray-900 ml-4">{{ $usuario->name }}</span>

                            </div>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Clave</span>

                            {{ $usuario->clave }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Email</span>

                            {{ $usuario->email }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Role</span>

                            @if ($usuario->roles()->count())

                                {{ $usuario->getRoleNames()->first() }}

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            @if($usuario->estado == 'activo')

                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->estado) }}</span>

                            @else

                                <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->estado) }}</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($usuario->creadoPor != null)Registrado por: {{$usuario->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $usuario->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($usuario->actualizadoPor != null)Actualizado por: {{$usuario->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $usuario->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    @can('Reestablecer contraseña')

                                        <button
                                            wire:click="resetearPassword({{ $usuario->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Reestablecer contraseña
                                        </button>

                                    @endcan

                                    @can('Editar permisos')

                                        <button
                                            wire:click="abrirModalPermisos({{ $usuario->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Permisos
                                        </button>

                                    @endcan

                                    @can('Editar usuario')

                                        <button
                                            wire:click="abrirModalEditar({{ $usuario->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Editar
                                        </button>

                                    @endcan

                                    @can('Borrar usuario')

                                        <button
                                            wire:click="abrirModalBorrar({{ $usuario->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Eliminar
                                        </button>

                                    @endcan

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="11">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="11" class="bg-gray-50">

                        {{ $this->usuarios->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            @if($crear)
                Nuevo Usuario
            @elseif($editar)
                Editar Usuario
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.name" label="Nombre" :error="$errors->first('modelo_editar.name')" class="w-full">

                        <x-input-text id="modelo_editar.name" wire:model="modelo_editar.name" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.email" label="Correo" :error="$errors->first('modelo_editar.email')" class="w-full">

                        <x-input-text id="modelo_editar.email" wire:model="modelo_editar.email" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.estado" label="Estado" :error="$errors->first('modelo_editar.estado')" class="w-full">

                        <x-input-select id="modelo_editar.estado" wire:model="modelo_editar.estado" class="w-full">

                            <option value="">Seleccione una opción</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>

                        </x-input-select>

                    </x-input-group>

                    <x-input-group for="role" label="Rol" :error="$errors->first('role')" class="w-full">

                        <x-input-select id="role" wire:model.live="role" class="w-full">

                            <option value="">Seleccione una opción</option>

                            @foreach ($roles as $itemR)

                                <option value="{{ $itemR->id }}">{{ $itemR->name }}</option>

                            @endforeach

                        </x-input-select>

                    </x-input-group>

                    @if(in_array($role , [2,3,4]))

                        <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                            <x-input-group for="modelo_editar.entidad_id" label="Notaria" :error="$errors->first('modelo_editar.entidad_id')" class="w-full">

                                <x-input-select id="modelo_editar.entidad_id" wire:model="modelo_editar.entidad_id" class="w-full">

                                    <option value="">Seleccione una opción</option>

                                    @foreach ($notarias as $notaria)

                                        <option value="{{ $notaria->id }}">Notaria {{ $notaria->numero_notaria }}</option>

                                    @endforeach

                                </x-input-select>

                            </x-input-group>

                        </div>

                    @elseif($role === "5")

                        <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                            <x-input-group for="modelo_editar.entidad_id" label="Dependencia" :error="$errors->first('modelo_editar.entidad_id')" class="w-full">

                                <x-input-select id="modelo_editar.entidad_id" wire:model="modelo_editar.entidad_id" class="w-full">

                                    <option value="">Seleccione una opción</option>

                                    @foreach ($dependencias as $dependencia)

                                        <option value="{{ $dependencia->id }}">{{ $dependencia->dependencia }}</option>

                                    @endforeach

                                </x-input-select>

                            </x-input-group>

                        </div>

                    @endif

                </div>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

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

                        Guardar
                    </x-button-blue>

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Actualizar
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
            Eliminar Usuario
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar al usuario? No sera posible recuperar la información.
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
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

    <x-dialog-modal wire:model="modalPermisos">

        <x-slot name="title">

            Asignar permisos

        </x-slot>

        <x-slot name="content">

            <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                <div class="flex-auto ">

                    <div>

                        <Label class="block text-sm font-medium leading-6 text-gray-900">Seleccione los permisos</Label>

                    </div>

                    <div class="overflow-y-auto ">

                        @foreach($permisos as $nombre => $area)

                            <p class="my-2">Área de {{ $nombre }}:</p>

                            <div class="mb-2 flex flex-wrap gap-2">

                                @foreach ($area as $permission)

                                    <label class="border border-gray-400 text-gray-500 px-2 rounded-full py-1 text-xs flex items-center">

                                        <input class="bg-white rounded" type="checkbox" wire:model.defer="listaDePermisos" value="{{ $permission['id'] }}">

                                        <p class="ml-2">{{ $permission['name'] }}</p>

                                    </label>

                                @endforeach

                            </div>

                            <hr>

                        @endforeach

                    </div>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="asignar"
                    wire:loading.attr="disabled"
                    wire:target="asignar">

                    <img wire:loading wire:target="asignar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Asiganr
                </x-button-blue>

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

</div>
