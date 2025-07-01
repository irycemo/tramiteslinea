<div>

    @if($aviso)

        @include('livewire.catastro.avisos.comun.folio-aviso')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg ">

            <div class="flex flex-col lg:flex-row gap-3">

                <div class="w-full lg:w-1/4 mx-auto space-y-3">

                    <div class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                        <div class="flex items-center ps-3">
                            <input type="checkbox" wire:model="aviso.no_genera_isai" name="sin reducción" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="sin reducción" class="w-full p-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No genera ISAI (fusiones, cuando las fracciones estan registradas al mismo propietario, divisiones, particiones y cuando no haya exedencia)</label>
                        </div>

                    </div>

                    <x-input-group for="aviso.valor_adquisicion" label="Valor de adquisición" :error="$errors->first('aviso.valor_adquisicion')" class="w-full">

                        <x-input-text type="number" id="aviso.valor_adquisicion" wire:model="aviso.valor_adquisicion" />

                    </x-input-group>

                    <div>

                        <span class="block text-sm font-medium leading-6 text-gray-900">Uso de predio</span>
                        <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input value="vivienda" wire:model.live="aviso.uso_de_predio" id="horizontal-list-radio-license" type="radio" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-license" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Vivienda</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input value="otro" wire:model.live="aviso.uso_de_predio" id="horizontal-list-radio-id" type="radio" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-id" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Otro</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input value="mixto" wire:model.live="aviso.uso_de_predio" id="horizontal-list-radio-military" type="radio" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-military" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mixto</label>
                                </div>
                            </li>
                        </ul>

                        @error('aviso.uso_de_predio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                    <x-input-group for="aviso.fecha_reduccion" label="Fecha de reducción" :error="$errors->first('aviso.fecha_reduccion')" class="w-full">

                        <x-input-text type="date" id="aviso.fecha_reduccion" wire:model.live="aviso.fecha_reduccion" />

                    </x-input-group>

                    <x-input-group for="aviso.valor_catastral" label="Valor del avaluo" :error="$errors->first('aviso.valor_catastral')" class="w-full">

                        <x-input-text type="number" id="aviso.valor_catastral" wire:model="aviso.valor_catastral"/>

                    </x-input-group>

                    @if($aviso->uso_de_predio === 'mixto')

                        <x-input-group for="aviso.valor_construccion_vivienda" label="Valor de construcción de la vivienda (solo en uso mixto)" :error="$errors->first('aviso.valor_construccion_vivienda')" class="w-full">

                            <x-input-text type="number" id="aviso.valor_construccion_vivienda" wire:model="aviso.valor_construccion_vivienda"/>

                        </x-input-group>

                        <x-input-group for="aviso.valor_construccion_otro" label="Valor de construcción de otro uso (solo en uso mixto)" :error="$errors->first('aviso.valor_construccion_otro')" class="w-full">

                            <x-input-text type="number" id="aviso.valor_construccion_otro" wire:model="aviso.valor_construccion_otro"/>

                        </x-input-group>

                    @endif

                    <x-input-group for="aviso.porcentaje_adquisicion" label="Porcentaje (en caso de aplicar)" :error="$errors->first('aviso.porcentaje_adquisicion')" class="w-full">

                        <x-input-text type="number" max="100" min="1" id="aviso.porcentaje_adquisicion" wire:model="aviso.porcentaje_adquisicion"/>

                    </x-input-group>

                    <div class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                        <div class="flex items-center ps-3">
                            <input type="checkbox" wire:model="aviso.sin_reduccion" name="sin reducción" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="sin reducción" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Predio sin reducción</label>
                        </div>

                    </div>

                    <button
                        wire:click="calcularIsai"
                        wire:loading.attr="disabled"
                        wire:target="calcularIsai"
                        type="button"
                        class="bg-blue-400 w-full hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                        <img wire:loading wire:target="calcularIsai" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Calcular ISAI

                    </button>

                </div>

                @if($aviso->valor_isai)

                    <div class="w-full lg:w-1/6 mx-auto space-y-3">

                        <x-input-group for="aviso.base_gravable" label="Base gravable" :error="$errors->first('aviso.base_gravable')" class="w-full">

                            <x-input-text type="number" id="aviso.base_gravable" wire:model="aviso.base_gravable" readonly/>

                        </x-input-group>

                        <x-input-group for="aviso.reduccion" label="Reducción" :error="$errors->first('aviso.reduccion')" class="w-full">

                            <x-input-text type="number" id="aviso.reduccion" wire:model="aviso.reduccion" readonly/>

                        </x-input-group>

                        <x-input-group for="aviso.valor_base" label="Valor base" :error="$errors->first('aviso.valor_base')" class="w-full">

                            <x-input-text type="number" id="aviso.valor_base" wire:model="aviso.valor_base" readonly/>

                        </x-input-group>

                        <x-input-group for="" label="Tasa (%)" :error="$errors->first('')" class="w-full">

                            <x-input-text type="number" id="" value="2" readonly/>

                        </x-input-group>

                        <x-input-group for="aviso.valor_isai" label="ISAI" :error="$errors->first('aviso.valor_isai')" class="w-full">

                            <x-input-text type="number" id="aviso.valor_isai" wire:model="aviso.valor_isai" readonly/>

                        </x-input-group>

                    </div>

                @endif

            </div>

        </div>

        @include('livewire.catastro.avisos.comun.errores')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end">

            <x-button-green
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar">

                <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

        </div>

    @endif

</div>
