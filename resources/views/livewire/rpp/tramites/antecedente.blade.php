<div class="space-y-5" wire:loading.class.delay.longest="opacity-50">

    <x-input-group for="folio_real" label="Folio real" :error="$errors->first('folio_real')" class="">

        <x-input-text type="number" id="folio_real" wire:model.live.debounce.150ms="folio_real" />

    </x-input-group>

</div>

{{-- <button
    wire:click="crearTramite"
    wire:loading.attr="disabled"
    wire:target="crearTramite"
    type="button"

    class="bg-blue-500 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none flex justify-center items-center w-full focus:outline-blue-400 focus:outline-offset-2">

    <img wire:loading wire:target="crearTramite" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

    <p>Consultar folio real</p>

</button> --}}
