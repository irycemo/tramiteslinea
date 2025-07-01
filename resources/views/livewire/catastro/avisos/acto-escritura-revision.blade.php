<div>

    @include('livewire.catastro.avisos.comun.folio-aviso')

    @if(!$aviso)

        <div class="space-y-2 mb-5 bg-white rounded-lg shadow-lg p-4">

            <ul class="grid w-full lg:w-1/2  mx-auto gap-6 md:grid-cols-2">

                <li>

                    <input type="radio" id="aviso" name="hosting" value="aviso" class="hidden peer" wire:model.live="radio">

                    <label for="aviso" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                        <div class="block">

                            <div class="w-full font-semibold">Ingresar aviso aclaratorio</div>

                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                        </svg>

                    </label>

                </li>

                <li>

                    <input type="radio" id="predio" name="hosting" value="predio" class="hidden peer" wire:model.live="radio">

                    <label for="predio" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                        <div class="block">

                            <div class="w-full font-semibold">Ingresar cuenta predial</div>

                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                        </svg>

                    </label>

                </li>

            </ul>

            @if($radio === 'aviso')

                <div>

                    <div class="flex-auto text-center mb-3 mt-8">

                        <div >

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Aviso aclaratorio</Label>

                        </div>

                        <div class="inline-flex">

                            <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año_aviso">
                                @foreach ($años as $año)

                                    <option value="{{ $año }}">{{ $año }}</option>

                                @endforeach
                            </select>

                            <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio_aviso') border-red-500 @enderror" wire:model="folio_aviso">

                            <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario_aviso') border-red-500 @enderror" wire:model="usuario_aviso">

                        </div>

                    </div>

                    <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                        <button
                            wire:click="consultarAviso"
                            wire:loading.attr="disabled"
                            wire:target="consultarAviso"
                            type="button"
                            class="bg-blue-400 mb-3 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                            <img wire:loading wire:target="consultarAviso" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Consultar aviso

                        </button>

                    </div>

                </div>

            @elseif($radio === 'predio')

                <div>

                    <div class="flex-auto text-center mb-3 mt-8">

                        <div class="text-center">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                        </div>

                        <div class="space-y-1">

                            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

                            <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio.oficina') border-1 border-red-500 @enderror" wire:model.blur="predio.oficina">

                            <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('predio.tipo_predio') border-1 border-red-500 @enderror" wire:model="predio.tipo_predio">

                            <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.blur="predio.numero_registro">

                        </div>

                    </div>

                    <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                        <button
                            wire:click="consultarCuentaPredial"
                            wire:loading.attr="disabled"
                            wire:target="consultarCuentaPredial"
                            type="button"
                            class="bg-blue-400 mb-3 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                            <img wire:loading wire:target="consultarCuentaPredial" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Consultar cuenta predial

                        </button>

                    </div>

                </div>

            @endif

        </div>

    @endif

    @if($aviso)

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <div class="flex-auto ">

                <div class="">

                    <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                        <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                        </div>

                        <div class="space-y-1">

                            <input readonly value="{{ $predio->localidad }}" title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20" >

                            <input readonly value="{{ $predio->oficina }}" title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->tipo_predio }}" title="Tipo de predio" placeholder="Tipo" type="number" min="1" max="2" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->numero_registro }}" title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20">

                        </div>

                    </div>

                    <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                        <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                        </div>

                        <div class="space-y-1">

                            <input readonly placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16">

                            <input readonly value="{{ $predio->region_catastral }}" title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20 ">

                            <input readonly value="{{ $predio->municipio }}" title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->zona_catastral }}" title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->localidad }}" title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->sector }}" title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->manzana }}" title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->predio }}" title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->edificio }}" title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20">

                            <input readonly value="{{ $predio->departamento }}" title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <x-input-group for="aviso.acto" label="Acto transmitivo de dominio" :error="$errors->first('aviso.acto')" class="w-fit mx-auto">

                <x-input-select id="aviso.acto" wire:model.live="aviso.acto">

                    <option value="">Seleccione una opción</option>

                    @foreach ($actos as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            <x-input-group for="aviso.fecha_ejecutoria" label="Para el caso de adquisición por resolución judicial, fecha en la que causo ejecutoria" :error="$errors->first('aviso.fecha_ejecutoria')" class="w-fit mx-auto">

                <x-input-text type="date" id="aviso.fecha_ejecutoria" wire:model="aviso.fecha_ejecutoria" />

            </x-input-group>

        </div>

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex flex-col lg:flex-row gap-3 justify-center items-center">

            <x-input-group for="aviso.tipo_escritura" label="Tipo de escritura" :error="$errors->first('aviso.tipo_escritura')" class="w-fit">

                <x-input-select id="aviso.tipo_escritura" wire:model.live="aviso.tipo_escritura">

                    <option value="">Seleccione una opción</option>

                    @foreach ($tipos_escritura as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            <x-input-group for="aviso.numero_escritura" label="Número de escritura" :error="$errors->first('aviso.numero_escritura')" class="w-fit">

                <x-input-text type="number" id="aviso.numero_escritura" wire:model="aviso.numero_escritura" />

            </x-input-group>

            <x-input-group for="aviso.volumen_escritura" label="Volumen" :error="$errors->first('aviso.volumen_escritura')" class="w-fit">

                <x-input-text type="number" id="aviso.volumen_escritura" wire:model="aviso.volumen_escritura" />

            </x-input-group>

        </div>

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg">

            <div class="flex gap-3 items-center w-full justify-center flex-col lg:flex-row">

                <x-input-group for="aviso.lugar_otorgamiento" label="Lugar de otorgamiento" :error="$errors->first('aviso.lugar_otorgamiento')" class="w-full lg:w-1/2">

                    <x-input-text id="aviso.lugar_otorgamiento" wire:model="aviso.lugar_otorgamiento" />

                </x-input-group>

                <x-input-group for="aviso.fecha_otorgamiento" label="Fecha de otorgamiento" :error="$errors->first('aviso.fecha_otorgamiento')" class="w-fit">

                    <x-input-text type="date" id="aviso.fecha_otorgamiento" wire:model="aviso.fecha_otorgamiento" />

                </x-input-group>

            </div>

            <div class="flex gap-3 items-center w-full justify-center flex-col lg:flex-row">

                <x-input-group for="aviso.lugar_firma" label="Lugar de firma" :error="$errors->first('aviso.lugar_firma')" class="w-full lg:w-1/2">

                    <x-input-text id="aviso.lugar_firma" wire:model="aviso.lugar_firma" />

                </x-input-group>

                <x-input-group for="aviso.fecha_firma" label="Fecha de firma" :error="$errors->first('aviso.fecha_firma')" class="w-fit">

                    <x-input-text type="date" id="aviso.fecha_firma" wire:model="aviso.fecha_firma" />

                </x-input-group>

            </div>

        </div>

        @include('livewire.catastro.avisos.comun.errores')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end">

            @if($actualizacion)

                <x-button-green
                    wire:click="actualizar"
                    wire:loading.attr="disabled"
                    wire:target="actualizar">

                    <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar

                </x-button-green>

            @else

                <x-button-green
                    wire:click="guardar"
                    wire:loading.attr="disabled"
                    wire:target="guardar">

                    <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Guardar

                </x-button-green>

            @endif

        </div>

    @endif

</div>
