<div class="space-y-5" wire:loading.class.delay.longest="opacity-50">

    <label class="block text-sm leading-6 text-gray-900 text-center font-semibold" for="folio_real">Folio Real</label>

    <x-input-group for="folio_real" label="" :error="$errors->first('folio_real')" class="">

        <x-input-text type="number" id="folio_real" wire:model.live.debounce.150ms="folio_real" />

    </x-input-group>

</div>


<div class="space-y-5 flex gap-3 items-end" wire:loading.class.delay.longest="opacity-50">

    <div>

        <label class="block text-sm font-medium leading-6 text-gray-900" for="distrito">Distrito</label>

        <select id="distrito" class="bg-white rounded-full text-sm w-full" wire:model="distrito" @if($folio_real) disabled @endif>

            <option value="" selected>Seleccione un distrito</option>
            <option value="2" class="truncate">Ururapan</option>

        </select>

    </div>

    <x-input-group for="tomo" label="Tomo" :error="$errors->first('tomo')" class="">

        <x-input-text type="number" id="tomo" wire:model.live.debounce.150ms="tomo" :readonly="$folio_real != null"/>

    </x-input-group>

    <x-input-group for="registro" label="Registro" :error="$errors->first('registro')" class="">

        <x-input-text type="number" id="registro" wire:model.live.debounce.150ms="registro" :readonly="$folio_real != null"/>

    </x-input-group>

    <x-input-group for="numero_propiedad" label="# de propiedad" :error="$errors->first('numero_propiedad')" class="">

        <x-input-text type="number" id="numero_propiedad" wire:model.live.debounce.150ms="numero_propiedad" :readonly="$folio_real != null"/>

    </x-input-group>

</div>