<div>

    <x-header>Crear o editar pregunta</x-header>

    <div class="bg-white rounded-lg shadow-xl p-4">

        <div class="w-full lg:w-1/2 mx-auto mb-5">

            <x-input-group for="titulo" label="Título" :error="$errors->first('titulo')" class="w-full mb-5">

                <x-input-text id="titulo" wire:model="titulo" />

            </x-input-group>

            <x-ck-editor property="contenido" id="content" class="w-full"></x-ck-editor>

            @if($errors->first('contenido'))

                <div class="text-red-500 text-sm mt-1"> {{ $errors->first('contenido') }} </div>

            @endif

        </div>

        <div class="w-full lg:w-1/2 mx-auto flex justify-end">

            @if ($pregunta)

                <x-button-blue
                    wire:click="actualizar">
                    Actualizar
                </x-button-blue>

            @else

                <x-button-blue
                    wire:click="guardar">
                    Guardar
                </x-button-blue>

            @endif

        </div>

    </div>

</div>
