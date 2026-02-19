<div class="">

    <x-header>Gestores</x-header>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading >Nombre</x-table.heading>
                <x-table.heading >Clave</x-table.heading>
                <x-table.heading >Correo</x-table.heading>
                <x-table.heading >Estado</x-table.heading>
                <x-table.heading >Entidad</x-table.heading>
                <x-table.heading >Registro</x-table.heading>
                <x-table.heading >Actualizado</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->usuarios as $usuario)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $usuario->id }}">

                        <x-table.cell title="Nombre">

                            <span class="text-sm text-gray-900 ml-4">{{ $usuario->name }}</span>

                        </x-table.cell>

                        <x-table.cell title="Clave">

                            {{ $usuario->clave }}

                        </x-table.cell>

                        <x-table.cell title="Email">

                            {{ $usuario->email }}

                        </x-table.cell>

                        <x-table.cell title="Estado">

                            @if($usuario->estado == 'activo')


                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->estado) }}</span>

                            @else

                                <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->estado) }}</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell title="Entidad">

                            {{ $usuario->entidad?->dependencia ?? 'Notaria: ' . $usuario->entidad?->numero_notaria  }}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            {{ $usuario->created_at }}

                        </x-table.cell>

                        <x-table.cell title="Actualizado">

                            {{ $usuario->updated_at }}

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="12">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>


                </x-table.row>

            </x-slot>

        </x-table>

    </div>

</div>
