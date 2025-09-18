<div>

    <x-header>Nuevo trámite</x-header>

    <div class="bg-white shadow-lg  rounded-lg p-4">

            <div class="lg:w-1/2 mx-auto flex flex-col justify-center items-center gap-3">

                <select class="bg-white rounded-full text-sm w-full" wire:model.live="servicio_id">

                    <option value="" selected>Seleccione un servicio</option>

                    @foreach ($servicios as $item)

                        <option value="{{ $item['id'] }}" class="truncate">{{ $item['nombre'] }}</option>

                    @endforeach

                </select>

                @if($servicio_id != '')

                    <div class="flex gap-2 w-full">

                        @if(auth()->user()->hasRole('Dependencia'))

                            <input type="text" class="bg-white rounded-full text-sm @error('numero_oficio') border-red-500 @enderror" wire:model.live="numero_oficio" placeholder="Número de oficio">

                        @endif

                    </div>

                    @if(in_array($servicioSeleccionado['clave_ingreso'], ['DL07']))

                        @include('livewire.rpp.tramites.antecedente')

                    @endif

                @endif

                @if($servicioSeleccionado != null && !in_array($servicioSeleccionado['clave_ingreso'], ['DL07']) || count($predio))

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

                        <form action="{{ $link_pago_linea }}" method="post" class="w-full">

                            <input type="hidden" name="concepto" value="IRYCEM">
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
