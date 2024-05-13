<div>

    @if(isset($aviso->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

        </div>

    @endif

    <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

        <div class="flex-auto text-center mb-3">

            <div >

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite del certificado</Label>

            </div>

            <div class="inline-flex">

                <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año">
                    @foreach ($años as $año)

                        <option value="{{ $año }}">{{ $año }}</option>

                    @endforeach
                </select>

                <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio') border-red-500 @enderror" wire:model="folio">

                <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario') border-red-500 @enderror" wire:model="usuario" readonly>

            </div>

        </div>

        @if($aviso->estado === 'nuevo')

            <div class="mb-3">

                <button
                    wire:click="buscarTramite"
                    wire:loading.attr="disabled"
                    wire:target="buscarTramite"
                    type="button"
                    class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarTramite" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Buscar trámtie

                </button>

            </div>

        @endif

    </div>

    @if($transmitentes)

        <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

            <x-input-group for="transmitente" label="Transmitente" :error="$errors->first('transmitente')" class="w-fit mx-auto mb-3">

                <x-input-select id="transmitente" wire:model="transmitente">

                    <option value="">Seleccione una opción</option>

                    @foreach ($transmitentes as $item)

                        <option value="{{ $item['id'] }}">{{ $item['nombre'] }} {{ $item['ap_paterno'] }} {{ $item['ap_materno'] }} {{ $item['razon_social'] }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            <button
                wire:click="agregarTransmitente"
                wire:loading.attr="disabled"
                wire:target="agregarTransmitente"
                type="button"
                class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                <img wire:loading wire:target="agregarTransmitente" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Agregar transmitente

            </button>

        </div>

    @endif

    @if($this->aviso->transmitentes()->count())

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

                        @foreach ($aviso->transmitentes() as $transmitente)

                            <x-table.row >

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de persona</span>

                                    {{ $transmitente->persona->tipo }}

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre / Razón social</span>

                                    <p class="pt-4">{{ $transmitente->persona->nombre }} {{ $transmitente->persona->ap_paterno }} {{ $transmitente->persona->ap_materno }} {{ $transmitente->persona->razon_social }}</p>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">% de propiedad</span>

                                    {{ number_format($transmitente->porcentaje, 2) }}%

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">% de nuda</span>

                                    {{ number_format($transmitente->porcentaje_nuda, 2) }}%

                                </x-table.cell>
                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">% de usufructo</span>

                                    {{ number_format($transmitente->porcentaje_usufructo, 2) }}%

                                </x-table.cell>
                                <x-table.cell>
                                    @if($aviso->estado === 'nuevo')

                                        <div class="flex items-center justify-center gap-3">
                                            <x-button-red
                                                wire:click="borrarTransmitente({{ $transmitente->id }})"
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

</div>
