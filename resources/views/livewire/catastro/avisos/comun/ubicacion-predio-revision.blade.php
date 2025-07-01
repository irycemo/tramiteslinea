<div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-xl">

    <h4 class="text-lg mb-5 text-center">Ubicación del predio</h4>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 items-start">

        <x-input-group for="aviso.predio.tipo_asentamiento" label="Tipo de asentamiento" :error="$errors->first('aviso.predio.tipo_asentamiento')" class="w-full">

            <x-input-select id="aviso.predio.tipo_asentamiento" wire:model="aviso.predio.tipo_asentamiento" class="w-full">

                <option value="">Seleccione una opción</option>

                @foreach ($tipoAsentamientos as $item)

                    <option value="{{ $item }}" selected>{{ $item }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

        <x-input-group for="aviso.predio.nombre_asentamiento" label="Nombre del asentamiento" :error="$errors->first('aviso.predio.nombre_asentamiento')" class="w-full">

            <x-input-text id="aviso.predio.nombre_asentamiento" wire:model="aviso.predio.nombre_asentamiento" />

        </x-input-group>

        <x-input-group for="aviso.predio.tipo_vialidad" label="Tipo de vialidad" :error="$errors->first('aviso.predio.tipo_vialidad')" class="w-full">

            <x-input-select id="aviso.predio.tipo_vialidad" wire:model="aviso.predio.tipo_vialidad" class="w-full">

                <option value="">Seleccione una opción</option>

                @foreach ($tipoVialidades as $item)

                    <option value="{{ $item }}" selected>{{ $item }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

        <x-input-group for="aviso.predio.nombre_vialidad" label="Nombre de la vialidad" :error="$errors->first('aviso.predio.nombre_vialidad')" class="w-full">

            <x-input-text id="aviso.predio.nombre_vialidad" wire:model="aviso.predio.nombre_vialidad" />

        </x-input-group>

        <x-input-group for="aviso.predio.numero_exterior" label="Número exterior" :error="$errors->first('aviso.predio.numero_exterior')" class="w-full">

            <x-input-text id="aviso.predio.numero_exterior" wire:model="aviso.predio.numero_exterior" />

        </x-input-group>

        <x-input-group for="aviso.predio.numero_exterior_2" label="Número exterior 2" :error="$errors->first('aviso.predio.numero_exterior_2')" class="w-full">

            <x-input-text id="aviso.predio.numero_exterior_2" wire:model="aviso.predio.numero_exterior_2" />

        </x-input-group>

        <x-input-group for="aviso.predio.numero_interior" label="Número interior" :error="$errors->first('aviso.predio.numero_interior')" class="w-full">

            <x-input-text id="aviso.predio.numero_interior" wire:model="aviso.predio.numero_interior" />

        </x-input-group>

        <x-input-group for="aviso.predio.numero_adicional" label="Número adicional" :error="$errors->first('aviso.predio.numero_adicional')" class="w-full">

            <x-input-text id="aviso.predio.numero_adicional" wire:model="aviso.predio.numero_adicional" />

        </x-input-group>

        <x-input-group for="aviso.predio.numero_adicional_2" label="Número adicional 2" :error="$errors->first('aviso.predio.numero_adicional_2')" class="w-full">

            <x-input-text id="aviso.predio.numero_adicional_2" wire:model="aviso.predio.numero_adicional_2" />

        </x-input-group>

        <x-input-group for="aviso.predio.codigo_postal" label="Código postal" :error="$errors->first('aviso.predio.codigo_postal')" class="w-full">

            <x-input-text type="number" id="aviso.predio.codigo_postal" wire:model="aviso.predio.codigo_postal" />

        </x-input-group>

        <x-input-group for="aviso.predio.lote_fraccionador" label="Lote del fraccionador" :error="$errors->first('aviso.predio.lote_fraccionador')" class="w-full">

            <x-input-text id="aviso.predio.lote_fraccionador" wire:model="aviso.predio.lote_fraccionador" />

        </x-input-group>

        <x-input-group for="aviso.predio.manzana_fraccionador" label="Manzana del fraccionador" :error="$errors->first('aviso.predio.manzana_fraccionador')" class="w-full">

            <x-input-text id="aviso.predio.manzana_fraccionador" wire:model="aviso.predio.manzana_fraccionador" />

        </x-input-group>

        <x-input-group for="aviso.predio.etapa_fraccionador" label="Etapa o zona del fraccionador" :error="$errors->first('aviso.predio.etapa_fraccionador')" class="w-full">

            <x-input-text id="aviso.predio.etapa_fraccionador" wire:model="aviso.predio.etapa_fraccionador" />

        </x-input-group>

        <x-input-group for="aviso.predio.nombre_edificio" label="Nombre del Edificio" :error="$errors->first('aviso.predio.nombre_edificio')" class="w-full">

            <x-input-text id="aviso.predio.nombre_edificio" wire:model="aviso.predio.nombre_edificio" />

        </x-input-group>

        <x-input-group for="aviso.predio.clave_edificio" label="Clave del edificio" :error="$errors->first('aviso.predio.clave_edificio')" class="w-full">

            <x-input-text id="aviso.predio.clave_edificio" wire:model="aviso.predio.clave_edificio" />

        </x-input-group>

        <x-input-group for="aviso.predio.departamento_edificio" label="Departamento" :error="$errors->first('aviso.predio.departamento_edificio')" class="w-full">

            <x-input-text id="aviso.predio.departamento_edificio" wire:model="aviso.predio.departamento_edificio" />

        </x-input-group>

        <x-input-group for="aviso.predio.nombre_predio" label="Predio Rústico Denominado ó Antecedente" :error="$errors->first('aviso.predio.nombre_predio')" class="col-span-2">

            <x-input-text id="aviso.predio.nombre_predio" wire:model="aviso.predio.nombre_predio" />

        </x-input-group>

    </div>

</div>