<div>

    <x-header>Nuevo trámite</x-header>

    <div class="flex justify-center lg:justify-end mb-3">

        <button
            class="bg-green-400 hover:shadow-lg justify-center text-white text-xs md:text-sm px-3 py-1 items-center rounded-full mr-2 hover:bg-green-700 flex focus:outline-none"
            wire:click="descargarFicha"
            wire:loading.attr="disabled"
            wire:target="descargarFicha">

            <div wire:loading.flex wire:target="descargarFicha" class="flex absolute top-1 right-1 items-center">
                <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            Descargar guia de servicios
        </button>

    </div>

    <div class="bg-white shadow-lg  rounded-lg p-4">

            <div class="lg:w-1/3 mx-auto flex flex-col justify-center items-center gap-3">

                <select class="bg-white rounded-full text-sm w-full" wire:model.live="servicio">

                    <option value="" selected>Seleccione un servicio</option>

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

                    <form action="{{ $url_pago_linea }}" method="post" class="w-full">

                        <input type="hidden" name="concepto" value="IRYCEM">
                        <input type="hidden" name="lcaptura" value="{{ $this->tramite['linea_de_captura'] }}">
                        <input type="hidden" name="monto" value="{{ $this->tramite['monto'] }}">
                        <input type="hidden" name="urlRetorno" value="{{ route('acredita_pago') }}">
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

            {{-- <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-full lg:w-1/4 mx-auto shadow-lg">

                <div class="text-center">
                    <span class="mx-auto font-bold">AVISO</span>
                </div>

                <p class="text-justify">
                    Por actualización de tarifas para los servicios de comercio publicadas en la Ley de Ingresos para el Ejercicio 2025,
                    el servicio de pago en línea se reestablecerá a partir de las 9:00 hrs. del día 17 del mes y año que corre.
                </p>

                <div class="text-center mt-4">
                    <span class="mx-auto font-bold">IMPORTANTE:</span>
                </div>

                <p class="text-justify">
                    Para evitar pagos complementarios, deberán estar al corriente en la inscripción y firma de trámites hasta el día de hoy.
                </p>

            </div> --}}

        </div>

    </div>

</div>
