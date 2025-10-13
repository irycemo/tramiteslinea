<div>

    @if($aviso)

        @include('livewire.catastro.avisos.comun.folio-aviso')

        @include('livewire.catastro.avisos.comun.ubicacion-predio-revision')

        @include('livewire.catastro.avisos.comun.coordenadas-revision')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

            <h4 class="text-lg mb-5 text-center">Croquis</h4>

            @if($aviso->croquis)

                <div class="flex justify-center">

                    <x-link-blue
                        href="{{ Storage::disk('avisos')->url($aviso->croquis->url) }}"
                        target="_blank"
                        >
                        Ver croquis
                    </x-link-blue>

                </div>

            @endif

            <div x-data="{ focused: false }" class="w-full md:w-1/2 lg:w-1/4 mx-auto">

                <span class="rounded-md shadow-sm">

                    <input @focus="focused = true" @blur="focused = false" class="sr-only" type="file" wire:model.live="croquis" id="croquis" accept="image/png, image/jpeg">

                    <label
                        for="croquis"
                        :class="{ 'outline-none border-blue-300 shadow-outline-blue': focused }" class="flex items-center relative justify-between w-full cursor-pointer py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        Croquis

                        <div wire:loading.flex wire:target="croquis" class="flex absolute top-1 right-1 items-center">
                            <svg class="animate-spin h-4 w-4 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        @if($croquis)

                            <span class=" text-blue-700" wire:loading.remove wire:target="croquis">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 rounded-full border border-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>

                            </span>

                        @endif

                    </label>

                </span>

            </div>

        </div>

        @include('livewire.catastro.avisos.comun.colindancias')

        <div class="bg-white rounded-lg p-3 flex flex-col lg:flex-row gap-3 mb-3 shadow-lg items-end">

            <x-input-group for="aviso.predio.superficie_total_terreno" label="Superficie total de terreno" class="w-full">

                <x-input-text type="number" id="aviso.predio.superficie_total_terreno" wire:model="aviso.predio.superficie_total_terreno" />

            </x-input-group>

            <x-input-group for="aviso.predio.superficie_total_construccion" label="Superficie total de construcción" class="w-full">

                <x-input-text type="number" id="aviso.predio.superficie_total_construccion" wire:model="aviso.predio.superficie_total_construccion" />

            </x-input-group>

            <x-input-group for="aviso.predio.valor_catastral" label="Valor catastral" class="w-full">

                <x-input-text type="number" id="aviso.predio.valor_catastral" wire:model="aviso.predio.valor_catastral" readonly/>

            </x-input-group>

            <x-input-group for="aviso.cantidad_tramitada" label="Lo tramitado constituye en relación con el título inmediato anterior" :error="$errors->first('aviso.cantidad_tramitada')" class="w-full">

                <x-input-select id="aviso.cantidad_tramitada" wire:model="aviso.cantidad_tramitada">

                    <option value="">Seleccione una opción</option>
                    <option value="LA TOTALIDAD">LA TOTALIDAD</option>
                    <option value="UNA FRACCIÓN">UNA FRACCIÓN</option>
                    <option value="EL RESTO">EL RESTO</option>

                </x-input-select>

            </x-input-group>

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
