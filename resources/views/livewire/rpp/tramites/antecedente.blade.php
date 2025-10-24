<div>

    @if ($flags['antecedente'])

        <x-h4>Antecedente de propiedad</x-h4>

        <div class="" wire:loading.class.delay.longest="opacity-50">

            <div class="grid grid-cols-1 md:grid-cols-4 mb-3 gap-4">

                <x-input-group for="folio_real" label="Folio real" :error="$errors->first('folio_real')" class="">

                    <x-input-text type="number" id="folio_real" wire:model.live.debounce.150ms="folio_real" />

                </x-input-group>

                <x-input-group for="distrito" label="Distrito" :error="$errors->first('distrito')" class="">

                    <x-input-select id="distrito" wire:model.live="distrito" class="w-full" :disabled="$folio_real != null ">

                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($distritos as $key => $item)

                            <option value="{{  $key }}">{{  $item }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

                <x-input-group for="tomo" label="Tomo" :error="$errors->first('tomo')" class="">

                    <x-input-text type="number" id="tomo" wire:model.lazy="tomo" :readonly="$folio_real != null"/>

                </x-input-group>

                <div class="flex items-end gap-2">

                    <x-input-group for="registro" label="Registro" :error="$errors->first('registro')" class="">

                        <x-input-text type="number" id="registro" wire:model.lazy="registro" :readonly="$folio_real != null"/>

                    </x-input-group>

                    @if(!$folio_real)

                        <button
                            wire:click="consultarAntecedentes"
                            wire:loading.attr="disabled"
                            wire:target="consultarAntecedentes"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg h-5 w-5 text-white text-center rounded-lg p-4 hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 relative">

                            <div wire:loading.flex class="flex absolute top-2 right-2 items-center">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>

                            <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 flex absolute top-2 right-2 items-center">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>

                        </button>

                    @else

                        <button
                                wire:click="consultarFolioReal"
                                wire:loading.attr="disabled"
                                wire:target="consultarFolioReal"
                                type="button"
                                class="bg-blue-400 hover:shadow-lg h-5 w-5 text-white text-center rounded-lg p-4 hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 relative">

                                <div wire:loading.flex class="flex absolute top-2 right-2 items-center">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>

                                <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 flex absolute top-2 right-2 items-center">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>

                            </button>

                    @endif

                </div>

            </div>

            <div>

                @if($flags['numero_propiedad'])

                    <div>
                        <x-input-group for="numero_propiedad" label="Número de propiedad" :error="$errors->first('numero_propiedad')">

                            <x-input-text type="number" id="numero_propiedad" wire:model.lazy="numero_propiedad" :disabled="$folio_real != null"/>

                        </x-input-group>

                    </div>

                @else

                    <div class="flex gap-2 items-end">

                        <x-input-group for="numero_propiedad" label="Número de propiedad" :error="$errors->first('numero_propiedad')" class=" col-span-2 w-full">

                            <x-input-select id="numero_propiedad" wire:model.lazy="numero_propiedad" class="w-full" :disabled="$folio_real != null ">

                                <option value="" selected>Seleccione una opción</option>

                                @foreach ($antecedentes as $key => $antecedente)

                                    <option title="{{ $antecedente['ubicacion'] }}" class="w-10" value="{{ $antecedente['noprop'] }}">{{ $antecedente['noprop'] }} - {{ Str::limit($antecedente['ubicacion'], 100) }}</option>

                                @endforeach

                            </x-input-select>

                        </x-input-group>

                        <button
                            wire:click="cambiarFlagNumeroPropiedad"
                            wire:loading.attr="disabled"
                            wire:target="cambiarFlagNumeroPropiedad"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg h-5 w-5 text-white text-center rounded-lg p-4 hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 relative">

                            <div wire:loading.flex class="flex absolute top-2 right-2 items-center">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>

                            <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 flex absolute top-2 right-2 items-center">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>

                        </button>

                    </div>

                @endif

            </div>

        </div>

    @endif

</div>
