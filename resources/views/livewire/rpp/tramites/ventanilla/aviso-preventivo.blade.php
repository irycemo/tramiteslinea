<div class="bg-white shadow-lg  rounded-lg p-4">

    <div class="lg:w-1/3 mx-auto flex flex-col justify-center items-center gap-3">

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

            @include('livewire.rpp.tramites.antecedente')

            <div class="my-5 w-full">

                <x-input-group for="descripcion_acto" label="Descripción del acto" :error="$errors->first('descripcion_acto')" class="w-full">

                    <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="descripcion_acto"></textarea>

                </x-input-group>

            </div>

            <div class="w-full mb-5">

                <div class="mb-5">

                     <label for="documento_entrada" class="block text-sm font-medium leading-6 text-gray-900">
                        Documento de entrada
                    </label>

                    <x-filepond wire:model.live="documento_entrada" accept="['application/pdf']"/>

                </div>

                <div>

                    @error('documento_entrada') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

                <x-input-group for="fecha_documento" label="Fecha del documento de entrada" :error="$errors->first('fecha_documento')">

                    <x-input-text type="date" id="fecha_documento" wire:model="fecha_documento"/>

                </x-input-group>

            </div>

        @endif

        @if($servicioSeleccionado != null)

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
                    wire:click="imprimirRecibo({{ json_encode($tramite) }})"
                    wire:loading.attr="disabled"
                    wire:target="imprimirRecibo({{ json_encode($tramite) }})"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none flex justify-center items-center w-full focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="imprimirRecibo({{ json_encode($tramite) }})" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <p>Pagar en ventanilla</p>

                </button>

                <form action="{{ $link_pago_linea }}" method="post" class="w-full">

                    <input type="hidden" name="concepto" value="{{ config('services.sap.concepto') }}">
                    <input type="hidden" name="lcaptura" value="{{ $tramite['linea_de_captura'] }}">
                    <input type="hidden" name="monto" value="{{ $tramite['monto'] }}">
                    <input type="hidden" name="urlRetorno" value="{{ route('acredita_pago') }}">
                    <input type="hidden" name="fecha_vencimiento" value="{{ $tramite['fecha_vencimiento'] }}">
                    <input type="hidden" name="tkn" value="{{ $token }}">
                    <input type="hidden" name="usuario" value="{{ $tramite['año'] . '-' . $tramite['folio'] . '-' . $tramite['usuario'] . ' ' . $nombre_solicitante }}">

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
