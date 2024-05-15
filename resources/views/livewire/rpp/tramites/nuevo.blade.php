<div>

    <x-header>Nuevo trámite</x-header>

    <div class="bg-white shadow-lg  rounded-lg p-4">

            <div class="lg:w-1/3 mx-auto flex flex-col justify-center items-center gap-3">

                <select class="bg-white rounded-full text-sm w-full" wire:model.live="servicio">

                    <option value="" selected>Servicio</option>

                    @foreach ($servicios as $item)

                        <option value="{{ $item['id'] }}" class="truncate">{{ $item['nombre'] }}</option>

                    @endforeach

                </select>

                @if($servicio != '')

                    <div class="flex gap-2">

                        <select class="bg-white rounded-full text-sm" wire:model.live="tipo_servicio">

                            <option value="ordinario" selected>Ordinario</option>
                            <option value="urgente">Urgente</option>
                            <option value="extra_urgente">Extra urgente</option>

                        </select>

                        @if(auth()->user()->hasRole('Dependencia'))

                            <input type="text" class="bg-white rounded-full text-sm @error('numero_oficio') border-red-500 @enderror" wire:model.live="numero_oficio" placeholder="Número de oficio">

                        @endif

                    </div>

                @endif

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

                    <form action="http://10.0.250.55:8081/pagolinea" method="post" class="w-full">

                        <input type="hidden" name="concepto" value="IRYCEM">
                        <input type="hidden" name="lcaptura" value="{{ $this->tramite['linea_de_captura'] }}">
                        <input type="hidden" name="monto" value="{{ $this->tramite['monto'] }}">
                        <input type="hidden" name="urlRetorno" value="http://127.0.0.1:8000/tramite_nuevo">
                        <input type="hidden" name="fecha_vencimiento" value="{{ $this->tramite['fecha_vencimiento'] }}">
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

            </div>

        </div>

    </div>

</div>
