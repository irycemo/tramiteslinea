<div>

    @if(isset($aviso->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

        </div>

    @endif

    @if(!$aviso->getKey())

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg">

            <div class="flex space-x-4 items-center justify-center">

                <x-checkbox wire:model.live="revision"></x-checkbox>

                <Label>Aviso aclaratorio</Label>

            </div>

            <div class="text-center">

                @if($revision)

                    <div >

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite del aviso</Label>

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

                    <div class="mb-3">

                        <button
                            wire:click="buscarAviso"
                            wire:loading.attr="disabled"
                            wire:target="buscarAviso"
                            type="button"
                            class="bg-blue-400 mt-3 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                            <img wire:loading wire:target="buscarAviso" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Buscar aviso

                        </button>

                    </div>

                @endif

            </div>

        </div>

    @endif

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <div class="flex gap-3 justify-center items-center">

            <x-input-group for="municipioSeleccionado" label="Municipios" :error="$errors->first('municipioSeleccionado')" class="text-center">

                <x-input-select id="municipioSeleccionado" wire:model.live="municipioSeleccionado">

                    <option value="">Seleccione una opción</option>

                    @foreach ($municipios as $item)

                        <option value="{{ $item['id'] }}">{{ $item['nombre'] }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            @if($oficina && count($localidades) > 0)

                <x-input-group for="localidadSeleccionada" label="Localidad" :error="$errors->first('localidadSeleccionada')" class="text-center">

                    <x-input-select id="localidadSeleccionada" wire:model.live="localidadSeleccionada">

                        <option value="">Seleccione una opción</option>

                        @foreach ($localidades as $item)

                            <option value="{{ $item['id'] }}">{{ $item['nombre'] }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

            @endif

        </div>

        <div class="flex-auto ">

            <div class="">

                <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                    </div>

                    <div class="space-y-1">

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                        <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.blur="oficina">

                        <input title="Tipo de predio" placeholder="Tipo" type="number" min="1" max="2" class="bg-white rounded text-xs w-20 @error('tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo_predio">

                        <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('numero_registro') border-1 border-red-500 @enderror" wire:model.blur="numero_registro">

                    </div>

                </div>

                <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                    </div>

                    <div class="space-y-1">

                        <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                        <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral" readonly>

                        <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio" readonly>

                        <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral" readonly>

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad" readonly>

                        <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model="sector" readonly>

                        <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana" readonly>

                        <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20 @error('predio') border-1 border-red-500 @enderror" wire:model.blur="predio" readonly>

                        <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio" readonly>

                        <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento" readonly>

                    </div>

                </div>

            </div>

            <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                <button
                    wire:click="buscarCuentaPredial"
                    wire:loading.attr="disabled"
                    wire:target="buscarCuentaPredial"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarCuentaPredial" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar clave catastral

                </button>

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

                @foreach ($actos as $item)

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

    @if(count($errors) > 0)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

            <ul class="flex gap-2 felx flex-wrap list-disc ml-5">
            @foreach ($errors->all() as $error)

                <li class="text-red-500 text-xs md:text-sm ml-5">
                    {{ $error }}
                </li>

            @endforeach

        </ul>

        </div>

    @endif

    @if($aviso->estado === 'nuevo')

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
                    wire:click="crear"
                    wire:loading.attr="disabled"
                    wire:target="crear">

                    <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Guardar

                </x-button-green>

            @endif

        </div>

    @endif

</div>
