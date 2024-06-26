<div>

    @if(isset($aviso->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-lg">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio: {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</span>

        </div>

    @endif

    @if($aviso->estado === 'nuevo')

        <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

            <div class="flex-auto text-center mb-3">

                <div >

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Folio del avalúo</Label>

                </div>

                <div class="inline-flex">

                    <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año">
                        @foreach ($años as $año)

                            <option value="{{ $año }}">{{ $año }}</option>

                        @endforeach
                    </select>

                    <input type="number" class="bg-white text-sm w-20 focus:ring-0 rounded-r @error('folio') border-red-500 @enderror" wire:model="folio">

                </div>

            </div>

            <div class="mb-3">

                <button
                    wire:click="cargarAvaluo"
                    wire:loading.attr="disabled"
                    wire:target="cargarAvaluo"
                    type="button"
                    class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="cargarAvaluo" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Cargar información del avalúo

                </button>

            </div>

        </div>

    @endif

    <div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-lg">

        <h4 class="text-lg mb-5 text-center">Ubicación del predio</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-3 items-start">

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Código postal</label>

                </div>

                <div>

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model="aviso.codigo_postal">

                </div>

                <div>

                    @error('aviso.codigo_postal') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto">

                <div>

                    <Label class="text-sm">Tipo de asentamiento</Label>
                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.tipo_asentamiento">

                </div>

                <div>

                    @error('aviso.tipo_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Nombre del asentamiento</label>

                </div>

                <div>

                    <input  class="bg-white rounded text-xs w-full" wire:model="aviso.nombre_asentamiento">

                </div>

                <div>

                    @error('aviso.nombre_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Tipo de vialidad</Label>
                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full" wire:model="aviso.tipo_vialidad">
                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($tipoVialidades as $item)

                            <option value="{{ $item }}" selected>{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

                <div>

                    @error('aviso.tipo_vialidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Nombre de la vialidad</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.nombre_vialidad">

                </div>

                <div>

                    @error('aviso.nombre_vialidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Número exterior</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.numero_exterior">

                </div>

                <div>

                    @error('aviso.numero_exterior') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Número exterior 2</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.numero_exterior_2">

                </div>

                <div>

                    @error('aviso.numero_exterior_2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Número interior</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.numero_interior">

                </div>

                <div>

                    @error('aviso.numero_interior') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Número adicional</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.numero_adicional">

                </div>

                <div>

                    @error('aviso.numero_adicional') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Número adicional 2</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.numero_adicional_2">

                </div>

                <div>

                    @error('aviso.numero_adicional_2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Lote del fraccionador</label>

                </div>

                <div>

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model="aviso.lote_fraccionador">

                </div>

                <div>

                    @error('aviso.lote_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Manzana del fraccionador</label>

                </div>

                <div>

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model="aviso.manzana_fraccionador">

                </div>

                <div>

                    @error('aviso.manzana_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Etapa o zona del fraccionador</label>

                </div>

                <div>

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model="aviso.etapa_fraccionador">

                </div>

                <div>

                    @error('aviso.etapa_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm">Nombre del Edificio</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.nombre_edificio">

                </div>

                <div>

                    @error('aviso.nombre_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm">Clave del edificio</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.clave_edificio">

                </div>

                <div>

                    @error('aviso.clave_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm">Departamento</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.departamento_edificio">

                </div>

                <div>

                    @error('aviso.departamento_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto grid-cols-1 md:col-span-2">

                <div>

                    <label class="text-sm">Predio Rústico Denominado ó Antecedente</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="aviso.nombre_predio">

                </div>

                <div>

                    @error('aviso.nombre_predio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </div>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-lg">

        <h4 class="text-lg mb-5 text-center">Coordenadas geográficas</h4>

        <div class="flex-auto mb-3">

            <div class="">

                <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">UTM</Label>

                    </div>

                    <div class="space-y-1">

                        <input placeholder="X" type="text" class="bg-white rounded text-xs w-40 @error('aviso.xutm') border-red-500 @enderror" wire:model.blur="aviso.xutm">

                        <input placeholder="Y" type="text" class="bg-white rounded text-xs w-40 @error('aviso.yutm') border-red-500 @enderror" wire:model.blur="aviso.yutm">

                        <select class="bg-white rounded text-xs" wire:model.blur="aviso.zutm">

                            <option value="" selected>Z</option>
                            <option value="13" selected>13</option>
                            <option value="14" selected>14</option>

                        </select>

                        <input placeholder="Norte" type="text" class="bg-white rounded text-xs w-40" readonly>

                    </div>

                </div>

            </div>

            <div class="">

                <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">GEO</Label>

                    </div>

                    <div class="space-y-1">

                        <input placeholder="Lat" type="number" class="bg-white rounded text-xs w-40 @error('aviso.lat') border-red-500 @enderror" wire:model.blur="aviso.lat">

                        <input placeholder="Lon" type="number" class="bg-white rounded text-xs w-40 @error('aviso.lon') border-red-500 @enderror" wire:model.blur="aviso.lon">

                    </div>

                </div>

            </div>

        </div>

        <div x-data="{ focused: false }" class="w-full md:w-1/2 lg:w-1/4 mx-auto">

            <span class="rounded-md shadow-sm">

                <input @focus="focused = true" @blur="focused = false" class="sr-only" type="file" wire:model.live="croquis" id="croquis">

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

            @if($aviso->croquis)

                <img class="h-40 mx-auto mt-3" src="{{ Storage::disk('avisos')->url($aviso->croquis->url) }}" alt="Croquis">

            @endif

        </div>

    </div>

    <div class="bg-white rounded-lg p-3 flex flex-col lg:flex-row gap-3 mb-3 shadow-lg items-end">

        <x-input-group for="aviso.superficie_terreno" label="Superficie de terreno" :error="$errors->first('aviso.superficie_terreno')" class="w-full">

            <x-input-text type="number" id="aviso.superficie_terreno" wire:model="aviso.superficie_terreno" />

        </x-input-group>

        <x-input-group for="aviso.superficie_construccion" label="Superficie de construcción" :error="$errors->first('aviso.superficie_construccion')" class="w-full">

            <x-input-text type="number" id="aviso.superficie_construccion" wire:model="aviso.superficie_construccion" />

        </x-input-group>

        <x-input-group for="aviso.valor_catastral" label="Valor catastral" :error="$errors->first('aviso.valor_catastral')" class="w-full">

            <x-input-text type="number" id="aviso.valor_catastral" wire:model="aviso.valor_catastral" />

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

    <div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-lg">

        <h4 class="text-lg mb-5 text-center">Colindancias</h4>

        <div class="mb-5  divide-y">

            @foreach ($medidas as $index => $medida)

                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start mb-2">

                    <div class="flex-auto lg:col-span-2">

                        <div>

                            <label class="text-sm" >Viento</label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-xs w-full" wire:model="medidas.{{ $index }}.viento">

                                <option value="" selected>Seleccione una opción</option>

                                @foreach ($vientos as $viento)

                                    <option value="{{ $viento }}" selected>{{ $viento }}</option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            @error('medidas.' . $index . '.viento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto lg:col-span-2">

                        <div>

                            <label class="text-sm" >Longitud</label>

                        </div>

                        <div>

                            <input type="number" min="0" class="bg-white rounded text-xs w-full" wire:model="medidas.{{ $index }}.longitud">

                        </div>

                        <div>

                            @error('medidas.' . $index . '.longitud') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto lg:col-span-7">

                        <div>

                            <label class="text-sm" >Descripción</label>

                        </div>

                        <div>

                            <textarea rows="1" class="bg-white rounded text-xs w-full" wire:model="medidas.{{ $index }}.descripcion"></textarea>

                        </div>

                        <div>

                            @error('medidas.' . $index . '.descripcion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto lg:col-span-1 my-auto">

                        @if($aviso->estado === 'nuevo')

                            <x-button-red
                                wire:click="borrarMedida({{ $index }})"
                                wire:loading.attr="disabled"
                                wire:target="borrarMedida({{ $index }})">

                                <img wire:loading wire:target="borrarMedida({{ $index }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                Borrar

                            </x-button-red>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

        <x-button-blue
            wire:click="agregarMedida"
            wire:loading.attr="disabled"
            wire:target="agregarMedida">

            <img wire:loading wire:target="agregarMedida" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Agregar nuevo

        </x-button-blue>

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
