<div>

    <x-header>Nuevo trámite</x-header>

    <div class="bg-white shadow-lg  rounded-lg p-4">

            <div class="lg:w-1/3 mx-auto flex flex-col justify-center items-center gap-3">

                <select class="bg-white rounded-full text-sm w-full" wire:model.live="servicio_id">

                    <option value="" selected>Seleccione un servicio</option>

                    @foreach ($servicios as $item)

                        <option value="{{ $item['id'] }}" class="truncate">{{ $item['nombre'] }}</option>

                    @endforeach

                </select>

                @if($servicio_id != '')

                    <div class="flex gap-2">

                        {{-- <select class="bg-white rounded-full text-sm" wire:model.live="tipo_servicio">

                            <option value="ordinario" selected>Ordinario</option>
                            <option value="urgente">Urgente</option>
                            <option value="extra_urgente">Extra urgente</option>

                        </select> --}}

                        @if(auth()->user()->hasRole('Dependencia'))

                            <input type="text" class="bg-white rounded-full text-sm @error('numero_oficio') border-red-500 @enderror" wire:model.live="numero_oficio" placeholder="Número de oficio">

                        @endif

                    </div>

                    <Label class="text-gray-700">Cuentas prediales involucradas</Label>

                    <div class="flex flex-col lg:flex-row gap-1 items-center justify-center">

                        <div>

                            <input placeholder="Localidad" type="number" class="bg-white rounded text-sm lg:w-24  @error('localidad') border-red-500 @enderror" wire:model="localidad">

                        </div>

                        <div>

                            <input placeholder="Oficina" type="number" class="bg-white rounded text-sm lg:w-24  @error('oficina') border-red-500 @enderror" wire:model="oficina">

                        </div>

                        <div >

                            <input placeholder="Tipo" type="number"  class="bg-white rounded text-sm lg:w-24 @error('tipo') border-red-500 @enderror" wire:model="tipo">

                        </div>

                        <div>

                            <input placeholder="Registro" type="number" class="bg-white rounded text-sm lg:w-24 @error('registro') border-red-500 @enderror" wire:model="registro">

                        </div>

                        <button
                            wire:click="agregarPredio"
                            wire:loading.attr="disabled"
                            wire:target="agregarPredio"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none flex items-center w-fit focus:outline-blue-400 focus:outline-offset-2">
                            <img wire:loading wire:target="agregarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            <p class="mr-1">Agregar</p>
                        </button>

                    </div>

                @endif

                @if(count($predios))

                    <div class="text-sm text-gray-700 my-3 w-full">

                        <table class="w-full">

                            <thead class="text-left bg-gray-100">

                                <tr>

                                    <th class="px-2">Localidad</th>
                                    <th class="px-2">Oficina</th>
                                    <th class="px-2">Tipo de predio</th>
                                    <th class="px-2">Número de registro</th>
                                    <th class="px-2"></th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($predios as $key => $item)

                                    <tr class="border-b py-1">
                                        <td class="px-2">
                                            {{ $item['localidad'] }}
                                        </td>
                                        <td class="px-2">
                                            <p>{{ $item['oficina'] }}</p>
                                        </td>
                                        <td class="px-2">
                                            <p>{{ $item['tipo_predio'] }}</p>
                                        </td>
                                        <td class="px-2">
                                            <p>{{ $item['numero_registro'] }}</p>
                                        </td>

                                        <td class="py-1">
                                            <button
                                                wire:click="quitarPredio({{ $key }})"
                                                wire:loading.attr="disabled"
                                                wire:target="quitarPredio({{ $key }})"
                                                class=" bg-red-400 text-white text-xs p-1 items-center rounded-full hover:bg-red-700 flex justify-center focus:outline-none"
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>

                                            </button>
                                        </td>

                                    </tr>

                                @endforeach

                                <tr >
                                    <td colspan="6" class="py-2">Total de predios: {{ count($predios) }}</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <p class="text-center font-semibold text-xl">Total: ${{ number_format($total, 2) }}</p>

                    @if(!$this->tramite)

                        <button
                            wire:click="crearTramite"
                            wire:loading.attr="disabled"
                            wire:target="crearTramite"
                            type="button"
                            class="bg-green-500 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none flex justify-center items-center w-full focus:outline-green-400 focus:outline-offset-2">

                            <img wire:loading wire:target="crearTramite" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            <p>Generar trámite</p>

                        </button>

                    @endif

                    @if($tramite)

                        <button
                            wire:click="pagarVentanilla"
                            wire:loading.attr="disabled"
                            wire:target="pagarVentanilla"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none flex justify-center items-center w-full focus:outline-blue-400 focus:outline-offset-2">

                            <img wire:loading wire:target="pagarVentanilla" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            <p>Pagar en ventanilla</p>

                        </button>

                        {{-- <button
                            wire:click="pagarEnLinea"
                            wire:loading.attr="disabled"
                            wire:target="pagarEnLinea"
                            type="button"
                            class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-red-700 focus:outline-none flex justify-center items-center w-full focus:outline-red-400 focus:outline-offset-2">

                            <img wire:loading wire:target="pagarEnLinea" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            <p>Pagar en línea</p>

                        </button> --}}

                        <form action="{{ $link_pago_linea }}" method="post" class="w-full">

                            <input type="hidden" name="concepto" value="{{ config('services.sap.secret_iv') }}">
                            <input type="hidden" name="lcaptura" value="{{ $tramite['linea_de_captura'] }}">
                            <input type="hidden" name="monto" value="{{ $tramite['monto'] }}">
                            <input type="hidden" name="urlRetorno" value="{{ route('acredita_pago') }}">
                            <input type="hidden" name="fecha_vencimiento" value="{{ $tramite['fecha_vencimiento'] }}">
                            <input type="hidden" name="tkn" value="{{ $token }}">

                            <button
                                wire:loading.attr="disabled"
                                type="submit"
                                class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-red-700 focus:outline-none flex justify-center items-center w-full focus:outline-bg-red-400 focus:outline-offset-2">

                                <img wire:loading wire:target="pagarEnLinea" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                <p>Pagar en linea</p>

                            </button>

                        </form>

                    @endif

                @endif

            </div>

        </div>

    </div>

</div>
