<div>

    @if($aviso)

        @include('livewire.catastro.avisos.comun.folio-aviso')

        @include('livewire.catastro.avisos.comun.ubicacion-predio')

        @include('livewire.catastro.avisos.comun.coordenadas')

        @include('livewire.catastro.avisos.comun.colindancias')

        <div class="bg-white rounded-lg p-3 flex flex-col lg:flex-row gap-3 mb-3 shadow-lg items-end">

            <x-input-group for="aviso.predio.superficie_total_terreno" label="Superficie de terreno" class="w-full">

                <x-input-text type="number" id="aviso.predio.superficie_total_terreno" value="{{ $aviso->predio->superficie_total_terreno }}" readonly/>

            </x-input-group>

            <x-input-group for="aviso.predio.superficie_construccion" label="Superficie de construcción" class="w-full">

                <x-input-text type="number" id="aviso.predio.superficie_construccion" value="{{ $aviso->predio->superficie_construccion }}" readonly/>

            </x-input-group>

            <x-input-group for="aviso.predio.valor_catastral" label="Valor catastral" class="w-full">

                <x-input-text type="number" id="aviso.predio.valor_catastral" value="{{ $aviso->predio->valor_catastral }}" readonly/>

            </x-input-group>

            <x-input-group for="aviso.cantidad_tramitada" label="Lo tramitado constituye en relación con el título inmediato anterior" :error="$errors->first('aviso.cantidad_tramitada')" class="w-full">

                <x-input-select id="aviso.cantidad_tramitada" wire:model="aviso.cantidad_tramitada" :disabled="(auth()->user()->entidad->dependencia === 'Secretaría de gobernación')">

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
