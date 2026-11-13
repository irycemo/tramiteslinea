<div>

    @push('styles')

        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    @endpush

    <x-header>Nuevo trámite</x-header>

    <div class="flex justify-center lg:justify-end mb-3">

        <button
            class="bg-green-500 hover:shadow-lg justify-center text-white text-xs md:text-sm px-3 py-1 items-center rounded-full mr-2 hover:bg-green-700 flex focus:outline-none"
            wire:click="descargarFicha"
            wire:loading.attr="disabled"
            wire:target="descargarFicha">

            <div wire:loading.flex wire:target="descargarFicha" class="flex absolute top-1 right-1 items-center">
                <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            Descargar guia de servicios
        </button>

    </div>

    <div class="bg-white shadow-lg  rounded-lg p-4 mb-5">

        <div class="lg:w-1/3 mx-auto flex flex-col justify-center items-center gap-3">

            <select class="bg-white rounded-full text-sm w-full" wire:model.live="categoria">

                <option value="" selected>Seleccione una categoría</option>
                <option value="comercio" selected>Comercio</option>
                <option value="certificaciones" selected>Certificaciones</option>
                {{-- <option value="aviso_preventivo" selected>Aviso Preventivo</option> --}}

            </select>

        </div>

    </div>

    @if($categoria === 'comercio')

        @livewire('rpp.tramites.ventanilla.comercio')

    @elseif($categoria === 'certificaciones')

        @livewire('rpp.tramites.ventanilla.certificaciones')

    @elseif($categoria === 'aviso_preventivo')

        @livewire('rpp.tramites.ventanilla.aviso-preventivo')

    @endif

    @push('scripts')

        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    @endpush

</div>
