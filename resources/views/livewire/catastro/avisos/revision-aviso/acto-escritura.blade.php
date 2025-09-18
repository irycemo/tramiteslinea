<div>

    @include('livewire.catastro.avisos.comun.folio-aviso')

    @if(!$aviso || !$aviso->avaluo_spe)

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <div class="flex-auto text-center mb-3">

                <div >

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Avalúo</Label>

                </div>

                <div class="inline-flex">

                    <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año_avaluo">
                        @foreach ($años as $año)

                            <option value="{{ $año }}">{{ $año }}</option>

                        @endforeach
                    </select>

                    <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio_avaluo') border-red-500 @enderror" wire:model="folio_avaluo">

                    <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario_avaluo') border-red-500 @enderror" wire:model="usuario_avaluo">

                </div>

            </div>

            <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                <button
                    wire:click="consultarAvaluo"
                    wire:loading.attr="disabled"
                    wire:target="consultarAvaluo"
                    type="button"
                    class="bg-blue-400 mb-3 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="consultarAvaluo" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar avalúo

                </button>

            </div>

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

            <x-input-group for="aviso.numero_escritura" label="Número de escritura" :error="$errors->first('aviso.numero_escritura')" class="lg:w-fit w-full">

                <x-input-text type="number" id="aviso.numero_escritura" wire:model="aviso.numero_escritura" />

            </x-input-group>

            <x-input-group for="aviso.volumen_escritura" label="Volumen" :error="$errors->first('aviso.volumen_escritura')" class="lg:w-fit w-full">

                <x-input-text type="number" id="aviso.volumen_escritura" wire:model="aviso.volumen_escritura" />

            </x-input-group>

        </div>

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg">

            <div class="flex gap-3 items-center w-full justify-center flex-col lg:flex-row">

                <x-input-group for="aviso.lugar_otorgamiento" label="Lugar de otorgamiento" :error="$errors->first('aviso.lugar_otorgamiento')" class="w-full lg:w-1/2">

                    <x-input-text id="aviso.lugar_otorgamiento" wire:model="aviso.lugar_otorgamiento" />

                </x-input-group>

                <x-input-group for="aviso.fecha_otorgamiento" label="Fecha de otorgamiento" :error="$errors->first('aviso.fecha_otorgamiento')" class="lg:w-fit w-full">

                    <x-input-text type="date" id="aviso.fecha_otorgamiento" wire:model="aviso.fecha_otorgamiento" />

                </x-input-group>

            </div>

            <div class="flex gap-3 items-center w-full justify-center flex-col lg:flex-row">

                <x-input-group for="aviso.lugar_firma" label="Lugar de firma" :error="$errors->first('aviso.lugar_firma')" class="w-full lg:w-1/2">

                    <x-input-text id="aviso.lugar_firma" wire:model="aviso.lugar_firma" />

                </x-input-group>

                <x-input-group for="aviso.fecha_firma" label="Fecha de firma" :error="$errors->first('aviso.fecha_firma')" class="lg:w-fit w-full">

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
