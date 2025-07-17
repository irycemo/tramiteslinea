<div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-xl">

    <h4 class="text-lg mb-5 text-center">Ubicación del predio</h4>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 items-start">

        <x-input-group for="aviso.predio.tipo_asentamiento" label="Tipo de asentamiento" class="w-full">

            <x-input-text id="aviso.predio.tipo_asentamiento" value="{{ $aviso->predio->tipo_asentamiento }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.nombre_asentamiento" label="Nombre del asentamiento" class="w-full">

            <x-input-text id="predio.nombre_asentamiento" value="{{ $aviso->predio->nombre_asentamiento }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.tipo_vialidad" label="Tipo de vialidad" class="w-full">

            <x-input-text id="predio.tipo_vialidad" value="{{ $aviso->predio->tipo_vialidad }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.nombre_vialidad" label="Nombre de la vialidad" class="w-full">

            <x-input-text id="predio.nombre_vialidad" value="{{ $aviso->predio->nombre_vialidad }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.numero_exterior" label="Número exterior" class="w-full">

            <x-input-text id="predio.numero_exterior" value="{{ $aviso->predio->numero_exterior }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.numero_exterior_2" label="Número exterior 2" class="w-full">

            <x-input-text id="predio.numero_exterior_2" value="{{ $aviso->predio->numero_exterior_2 }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.numero_interior" label="Número interior" class="w-full">

            <x-input-text id="predio.numero_interior" value="{{ $aviso->predio->numero_interior }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.numero_adicional" label="Número adicional" class="w-full">

            <x-input-text id="predio.numero_adicional" value="{{ $aviso->predio->numero_adicional }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.numero_adicional_2" label="Número adicional 2" class="w-full">

            <x-input-text id="predio.numero_adicional_2" value="{{ $aviso->predio->numero_adicional_2 }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.codigo_postal" label="Código postal" class="w-full">

            <x-input-text type="number" id="predio.codigo_postal" value="{{ $aviso->predio->codigo_postal }}" readonly />

        </x-input-group>

        <x-input-group for="predio.lote_fraccionador" label="Lote del fraccionador" class="w-full">

            <x-input-text id="predio.lote_fraccionador" value="{{ $aviso->predio->lote_fraccionador }}" readonly />

        </x-input-group>

        <x-input-group for="predio.manzana_fraccionador" label="Manzana del fraccionador" class="w-full">

            <x-input-text id="predio.manzana_fraccionador" value="{{ $aviso->predio->lote_fraccionador }}" readonly />

        </x-input-group>

        <x-input-group for="predio.etapa_fraccionador" label="Etapa o zona del fraccionador" class="w-full">

            <x-input-text id="predio.etapa_fraccionador" value="{{ $aviso->predio->etapa_fraccionador }}" readonly />

        </x-input-group>

        <x-input-group for="predio.nombre_edificio" label="Nombre del Edificio" class="w-full">

            <x-input-text id="predio.nombre_edificio" value="{{ $aviso->predio->nombre_edificio }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.clave_edificio" label="Clave del edificio" class="w-full">

            <x-input-text id="predio.clave_edificio" value="{{ $aviso->predio->clave_edificio }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.departamento_edificio" label="Departamento" class="w-full">

            <x-input-text id="predio.departamento_edificio" value="{{ $aviso->predio->departamento_edificio }}" readonly/>

        </x-input-group>

        <x-input-group for="predio.nombre_predio" label="Predio Rústico Denominado ó Antecedente" class="col-span-2">

            <x-input-text id="predio.nombre_predio" value="{{ $aviso->predio->nombre_predio }}"/>

        </x-input-group>

    </div>

</div>