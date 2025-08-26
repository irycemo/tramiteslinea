<div>

    @if($aviso)

        @include('livewire.catastro.avisos.comun.folio-aviso')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

            @if($aviso->archivo()->first())

                <div class="flex justify-center">

                    <x-link-blue
                        href="{{ Storage::disk('avisos')->url($aviso->archivo()->first()->url) }}"
                        target="_blank"
                        >
                        Descargar archivo actual
                    </x-link-blue>

                </div>

            @endif

            <div class="w-full md:w-1/2 lg:w-1/4 mx-auto items-center text-center">

                <div class="mb-5">

                    <x-filepond wire:model.live="documento" accept="['application/pdf']"/>

                </div>

                <div>

                    @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </div>

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <x-input-group for="aviso.observaciones" label="Observaciones generales del aviso" :error="$errors->first('aviso.observaciones')" class="w-full lg:w-1/2 mx-auto">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="aviso.observaciones"></textarea>

            </x-input-group>

        </div>

        @include('livewire.catastro.avisos.comun.errores')

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end gap-4">

            <x-button-green
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar">

                <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

            <x-button-red
                wire:click="cerrar"
                wire:loading.attr="disabled"
                wire:target="cerrar">

                <img wire:loading wire:target="cerrar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Cerrar aviso

            </x-button-red>

        </div>

    @endif

</div>
